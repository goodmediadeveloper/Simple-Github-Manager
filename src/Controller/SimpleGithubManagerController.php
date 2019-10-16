<?php

namespace Drupal\simple_github_manager\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Simple Github Manager routes.
 */
class SimpleGithubManagerController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    //    get json repositories GitHub    //

    $ch = curl_init();

    $user_name = 'your____user___name';
    $token = 'your___access___tocken';

    curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/users/goodmediadeveloper/repos');
    curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/php');
    curl_setopt($ch, CURLOPT_USERPWD, $user_name . ':' . $token);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $result = json_decode(curl_exec($ch));

    //    END get json repositories GitHub    //
    $my_form = \Drupal::formBuilder()
      ->getForm('Drupal\simple_github_manager\Form\SimpleGithubManagerForm');
    //    $my_form['type']['#value'] = 'From my controller';
    $build['simple_github_manager']['#attached']['library'][] = 'simple_github_manager/simple_github_manager';

    $build[] = [
      '#url_parent' => 'https://github.com/',
      '#git_repo_arr' => $result,
      '#theme' => 'simple_github_manager',
      '#my_form' => $my_form,


    ];

    return $build;
  }

}
