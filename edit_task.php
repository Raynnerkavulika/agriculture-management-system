<?php
include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
};


if(isset($_POST['edit_task'])){
    
    $id = $_POST['id'];
    $task_name = $_POST['task_name'];
    $description = $_POST['description'];
    $assigned_worker = $_POST['assigned_worker'];
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];
  

    $update_task  = $conn->prepare("UPDATE `tasks` SET task_name=?,description=?,assigned_worker=?,deadline=?,priority=? WHERE id=?");
    $update_task->execute([$task_name,$description,$assigned_worker,$deadline,$priority,$id]);
    $message[] = 'the task has been updated successfully';

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit task</title>
     <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

     <!-- custom css link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php  
   if(isset($message)){
    foreach($message as $message){
        echo'
        <div class="message">
            <span>'.$message.'</span>
        </div>
        ';
    }
   }

?>
<!-- admin header starts -->
<?php include('admin_header.php'); ?>
<!-- admin header ends -->

<section class="edit-task">
    <h1 class="title">edit task</h1>

    <?php
      $update_id = $_GET['edit'];
      $select_task = $conn->prepare("SELECT * FROM `tasks` WHERE id =?");
      $select_task->execute([$update_id]);

      if($select_task->rowCount()){
        while($fetch_task = $select_task->fetch(PDO::FETCH_ASSOC)){

    
    ?>

<form action="" method="POST">
    <input type="hidden" name="id" value="<?= $fetch_task['id'];?>">
    <div class="form-group">
        <label for="task_name">Task Name:</label>
        <input type="text" value="<?= $fetch_task['task_name']; ?>" name="task_name" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" required><?= $fetch_task['description']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="worker">Assign to Worker:</label>
        <select name="assigned_worker" required>
        <option selected value=""><?= $fetch_task['assigned_worker']; ?></option>
            <?php
            $select_worker = $conn->prepare("SELECT * FROM `workers`");
            $select_worker->execute();
            if($select_worker->rowCount()>0){
                while($fetch_worker = $select_worker->fetch(PDO::FETCH_ASSOC)){
            ?>
                 <option value=""><?= $fetch_worker['full_name'];?></option>
            <?php 
                  }
                }else{
                  echo'<p class="empty">no worker has been added yet!</p>';
                }
            ?>
        </select>
     </div>
     <div class="form-group">
        <label for="deadline">Deadline:</label>
        <input type="date" name="deadline" value="<?= $fetch_task['deadline']; ?>" required>
     </div>
     <div class="form-group">
        <label for="priority">Priority:</label>
        <select name="priority" required>
            <option value="Low">Low</option>
            <option value="Medium">Medium</option>
            <option value="High">High</option>
        </select>
     </div>
        <input type="hidden" name="status" value="Pending">

        <div class="flex-btn">
            <input type="submit" value="update" class="btn" name="edit_task">
            <a href="manage_task.php" class="option-btn">go back</a>
        </div>
    </form>

    <?php
}
        
}else{
   echo'<p class="empty">no tasks have been found!</p>';
}
    ?>
</section>




<?php include "footer.php"; ?>


<script src="script.js"></script>
</body>
</html>
