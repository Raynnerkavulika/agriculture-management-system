<?php  
include "config.php";
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
  header("location:login.php");
}; 


if(isset($_GET['delete'])){
        
  $delete_id = $_GET['delete'];
  $delete_task = $conn->prepare("DELETE FROM `tasks` WHERE id=?");
  $delete_task->execute([$delete_id]);
  $message[] ="task has been deleted successfully";
};   



if(isset($_POST['submit_task'])) {
  $task_name = $_POST['task_name'];
  $description = $_POST['description'];
  $assigned_worker = $_POST['assigned_worker'];
  $deadline = $_POST['deadline'];
  $priority = $_POST['priority'];
  $status = $_POST['status'];

  $select_task = $conn->prepare("SELECT * FROM `tasks` WHERE task_name = ?");
   $select_task->execute([$task_name]);


  if($select_task ->rowCount() >0){
    $message[] = 'task already assigned';
}else{
   $insert_task = $conn->prepare("INSERT INTO `tasks`(task_name, description, assigned_worker, deadline, priority, status) VALUES(?,?,?,?,?,?)");
   $insert_task->execute([$task_name, $description, $assigned_worker, $deadline, $priority, $status]);

   $message[] = "task has been assigned successfully";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Farm Management - Task Management</title>
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

<?php include "admin_header.php"; ?>

<section class="manage-task">
    <h3 class="title" style="text-align: center;">manage tasks</h3>

    <div class="box-container">
      <div class="box">
              <?php
                    $select_task = $conn->prepare("SELECT * FROM `tasks`");
                    $select_task->execute();
                    $number_of_task = $select_task->rowCount();
              ?>

              <h3><?= $number_of_task;?></h3>
              <p>total tasks</p>
      </div>

      <div class="box">
              <?php
                    $select_pending_task = $conn->prepare("SELECT * FROM `tasks` WHERE status = ?");
                    $select_pending_task->execute(['pending']);
                    $number_of_pending_task = $select_pending_task->rowCount();
              ?>

               <h3><?= $number_of_pending_task;?></h3>
              <p>pending tasks</p>
      </div>

      <div class="box">
              <?php
                    $select_completed_task = $conn->prepare("SELECT * FROM `tasks` WHERE status = ?");
                    $select_completed_task->execute(['completed']);
                    $number_of_completed_task = $select_completed_task->rowCount();
              ?>

               <h3><?= $number_of_completed_task;?></h3>
              <p>completed tasks</p>
      </div>
    </div>
  </section>

   
  <section class="add-task">
    <h2>Assign New Task</h2>
    <form action="" method="POST">
    <div class="form-group">
        <label for="task_name">Task Name:</label>
        <input type="text" name="task_name" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="worker">Assign to Worker:</label>
        <select name="assigned_worker" required>
        <option selected disabled value="">select a worker</option>
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
        <input type="date" name="deadline" required>
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

        <input type="submit" name="submit_task" value="assign task" class="btn">
    </form>

    </section>
</body>
</html>


    <!-- task List Section -->
  <section class="user-management">

<h3 class="title" style="text-align: center;">task list</h3>

<table id="tasksTable">
      <thead>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <!-- <th>Assigned to</th> -->
            <th>Due Date</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Example of task row -->
        <?php
       $select_task = $conn->prepare("SELECT * FROM `tasks`");
       $select_task->execute();
       if($select_task->rowCount()>0){
          while($fetch_task = $select_task->fetch(PDO::FETCH_ASSOC)){

            
      ?>
       

        <tr>
          <td><?= $fetch_task['task_name'];?></td>
          <td><?= $fetch_task['description'];?></td>
          <!-- <td><?= $fetch_task['assigned_worker'];?></td> -->
          <td><?= $fetch_task['deadline'];?></td>
          <td><?= $fetch_task['priority'];?></td>
          <td><?= $fetch_task['status'];?></td>
          <td>
          <div class="flex-btn">
                      <a href="edit_task.php?edit=<?= $fetch_task['id'];?>" class="option-btn">edit</a>
                      <a href="manage_task.php?delete=<?= $fetch_task['id'];?>" class="delete-btn" onclick="return confirm('delete this user');">delete </a>
          </div>
          </td>
        </tr>

          <?php
              }
            }else{
              echo'<p class="empty">no task have been added yet!</p>';
            }
          ?>
      </tbody>
    </table>
</section>

<?php include "footer.php"; ?>

  
  <script src="script.js"></script>
</body>
</html>
