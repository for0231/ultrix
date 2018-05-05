<?php

namespace Drupal\order\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\order\Entity\OrderInterface;

/**
 * Class OrderController.
 *
 *  Returns responses for Order routes.
 */
class OrderController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Order  revision.
   *
   * @param int $order_revision
   *   The Order  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionShow($order_revision) {
    $order = $this->entityManager()->getStorage('order')->loadRevision($order_revision);
    $view_builder = $this->entityManager()->getViewBuilder('order');

    return $view_builder->view($order);
  }

  /**
   * Page title callback for a Order  revision.
   *
   * @param int $order_revision
   *   The Order  revision ID.
   *
   * @return string
   *   The page title.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionPageTitle($order_revision) {
    $order = $this->entityManager()->getStorage('order')->loadRevision($order_revision);
    return $this->t('Revision of %title from %date', ['%title' => $order->label(), '%date' => format_date($order->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Order .
   *
   * @param \Drupal\order\Entity\OrderInterface $order
   *   A Order  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionOverview(OrderInterface $order) {
    $account = $this->currentUser();
    $langcode = $order->language()->getId();
    $langname = $order->language()->getName();
    $languages = $order->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $order_storage = $this->entityManager()->getStorage('order');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $order->label()]) : $this->t('Revisions for %title', ['%title' => $order->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all order revisions") || $account->hasPermission('administer orders')));
    $delete_permission = (($account->hasPermission("delete all order revisions") || $account->hasPermission('administer orders')));

    $rows = [];

    $vids = $order_storage->revisionIds($order);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\order\OrderInterface $revision */
      $revision = $order_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $order->getRevisionId()) {
          $link = $this->l($date, new Url('entity.order.revision', ['order' => $order->id(), 'order_revision' => $vid]));
        }
        else {
          $link = $order->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.order.translation_revert', ['order' => $order->id(), 'order_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.order.revision_revert', ['order' => $order->id(), 'order_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.order.revision_delete', ['order' => $order->id(), 'order_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['order_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
