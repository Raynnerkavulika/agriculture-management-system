<header class="header">
<div class="flex">

<a href="dashboard.php" class="logo">Agriculture <span>management</span></a>

     <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_farmer.php">Farmers Management</a>
        <a href="manage_worker.php">Workers Management</a>
        <a href="manage_farm.php">farm Management</a>
        <a href="manage_task.php">Task Management</a>
        <a href="reports.php">Reports</a>
     </div>

     <div class="icons">
        <div id="user-btn" class="fas fa-user"></div>
        <div id="menu-btn" class="fas fa-bars"></div>
     </div>

     <div class="profile">
        <?php
           $select_profile = $conn->prepare("SELECT * FROM users WHERE id=?");
           $select_profile->execute([$admin_id]);
           $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        
        ?>
        <h3><?= $fetch_profile['name'];?></h3>
        <h3><?= $fetch_profile['email'];?></h3>
        

        <a href="update_profile.php" class="btn">update profile</a>
        <a href="logout.php" class="delete-btn">logout</a>
     </div>
</div>
    
</header>

