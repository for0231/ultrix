<?php

namespace Drupal\idc_product\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\idc_product\Entity\IdcProductInterface;

/**
 * Class IdcProductController.
 *
 *  Returns responses for Idc Product routes.
 */
class IdcProductController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Idc Product  revision.
   *
   * @param int $idc_product_revision
   *   The Idc Product  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionShow($idc_product_revision) {
    $idc_product = $this->entityManager()->getStorage('idc_product')->loadRevision($idc_product_revision);
    $view_builder = $this->entityManager()->getViewBuilder('idc_product');

    return $view_builder->view($idc_product);
  }

  /**
   * Page title callback for a Idc Product  revision.
   *
   * @param int $idc_product_revision
   *   The Idc Product  revision ID.
   *
   * @return string
   *   The page title.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionPageTitle($idc_product_revision) {
    $idc_product = $this->entityManager()->getStorage('idc_product')->loadRevision($idc_product_revision);
    return $this->t('Revision of %title from %date', ['%title' => $idc_product->label(), '%date' => format_date($idc_product->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Idc Product .
   *
   * @param \Drupal\idc_product\Entity\IdcProductInterface $idc_product
   *   A Idc Product  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function revisionOverview(IdcProductInterface $idc_product) {
    $account = $this->currentUser();
    $langcode = $idc_product->language()->getId();
    $langname = $idc_product->language()->getName();
    $languages = $idc_product->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $idc_product_storage = $this->entityManager()->getStorage('idc_product');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $idc_product->label()]) : $this->t('Revisions for %title', ['%title' => $idc_product->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all idc product revisions") || $account->hasPermission('administer idc products')));
    $delete_permission = (($account->hasPermission("delete all idc product revisions") || $account->hasPermission('administer idc products')));

    $rows = [];

    $vids = $idc_product_storage->revisionIds($idc_product);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\idc_product\IdcProductInterface $revision */
      $revision = $idc_product_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $idc_product->getRevisionId()) {
          $link = $this->l($date, new Url('entity.idc_product.revision', ['idc_product' => $idc_product->id(), 'idc_product_revision' => $vid]));
        }
        else {
          $link = $idc_product->link($date);
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
              Url::fromRoute('entity.idc_product.translation_revert', ['idc_product' => $idc_product->id(), 'idc_product_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.idc_product.revision_revert', ['idc_product' => $idc_product->id(), 'idc_product_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.idc_product.revision_delete', ['idc_product' => $idc_product->id(), 'idc_product_revision' => $vid]),
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

    $build['idc_product_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
