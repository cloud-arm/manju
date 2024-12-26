<nav class="nav">
        <div class="nav-item <?php if($nav=="home"){ echo "active";} ?>" id="index.php">
            <i class="fa fa-house"></i>
            <span class="nav-text">Home</span>
        </div>
        <div class="nav-item <?php if($nav=="GRN"){ echo "active";} ?>" id="grn.php">
        <span class="material-symbols-outlined">
deployed_code_update
</span>
            <span class="nav-text">GRN</span>
        </div>

        <div class="nav-item <?php if($nav=="report"){ echo "active";} ?>" id="">
            <i class="ion-stats-bars menu-icon"></i>
            <span class="nav-text">Reports</span>
        </div>
        <div class="nav-item <?php if($nav=="product"){ echo "active";} ?>" id="">
        <i class="fa-solid fa-box "></i>
            <span class="nav-text">Product</span>
        </div>

    </nav>