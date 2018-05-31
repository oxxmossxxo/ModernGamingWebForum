<?php
namespace app\controller;

use app\model\Topic as TopicModel;
use app\model\User;
use app\model\Role;
use app\model\Comment;
use app\view\TopicCreate;
use app\view\TopicView;
use app\App;

class Topic extends Crud {
  public function modelClass(){
    return "app\\model\\Topic";
  }

  public function getTitle(){
    switch ( $this->action ){
      case "View":
        return "";
    }
    return parent::getTitle();
  }
  
  public function getRelatedFields(){
    return array(
      "board_id" => array(
        "class_name" => "app\model\Board",
      ),
      "created_by" => array(
        "class_name" => "app\model\User"
      )
    );
  }

  public function actionView(){
    $app = App::app();
    $user = User::getLoggedInUser();
    $data = $app->request->get();
    $id = null;
    if ( isset($data['id']) ){
      $id = $data['id'];
    }
    $model = new TopicModel($id);
    $can_delete = false;
    if( $user && $user->id && $model && $model->created_by ){
      $can_delete = ($user->id == $model->created_by) ? true : false;
    }
    $data = array(
      "model" => $model,
      "user" => $user,
      "creator" => new User($model->created_by),
      "can_delete_topic" => $can_delete
    );
    /*
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    exit;
     */
    return new TopicView($data);
  }

  public function actionAddComment(){
    $app = App::app();
    $user = User::getLoggedInUser();
    $data = $app->request->post();
    $id = null;
    if ( isset($data['topic_id']) ){
      $id = $data['topic_id'];
    }
    $model = new TopicModel($id);
    if ( $model && $model->id && $user && $user->id ){
      $comment = new Comment();
      $comment->created_by = $user->id;
      $comment->topic_id = $model->id;
      if ( isset($data['body']) ){
        $comment->body = $data['body'];
      }
      if ( $comment->save() ){
        $app->setMessage("Your comment has been added.", "success");
      } else {
        $app->setMessage("There was an error creating your comment", "danger");
      }
      header("location: index.php?controller=topic&action=view&id={$model->id}");
      exit;
    }
    $app->setMessage("Invalid Topic", "danger");
    header("location: index.php");
    exit;
  }
  public function actionCreate(){
    $app = App::app();
    $user = User::getLoggedInUser();
    $data = $app->request->get();
    $board_id = null;
    $model = new TopicModel();
    $model->created_by = $user->id;
    if ( $app->request->isPost() ){
      $data = $app->request->post();
      if ( isset($data['submit']) && $data['submit'] == "cancel" ){
        header("location: index.php?controller=board&action=view&id=" . $data['board_id']);
        exit;
      } 
      $model = new TopicModel();
      $fields = $model->getFields();
      foreach ( $data as $field => $value ){
        if ( in_array($field, $fields) ){
          $model->$field = $data[$field]; 
        } 
      }
      $model->validate();
      if ( !$model->hasErrors() && $model->save() ){
        $app->setMessage("Topic Created", "success");
        header("location: index.php?controller=topic&action=view&id=" . $model->id);
        exit;
      }
    }

    if ( isset($data['board_id']) ){
      $board_id = $data['board_id'];
    }
    if ( !$board_id ){
      $app->setMessage("Invalid Board selected", "danger");
      header("location: index.php?controller=board");
      exit;
    }
    $model->board_id = $board_id;
    return new TopicCreate( array(
      "model" => $model
    ) );
  }

  public function getRequiredRole(){
    $role = Role::userRole();
    switch ( $this->action ){
      case "Create":
      case "AddComment":
        return $role;
    }
    return parent::getRequiredRole();
  }

  public function canPerform(){
    $app = App::app();
    $user = User::getLoggedInUser();
    $get = $app->request->get();
    switch ( $this->action ){
      case "Edit":
      case "Delete":
        if ( isset($get['id']) && $user && $user->id ){
          $model = new TopicModel($get['id']);
          if ( $model && $model->created_by ){
            return $model->created_by == $user->id;
          }
        }
        return false;
    }
    return parent::canPerform();
  }
}
