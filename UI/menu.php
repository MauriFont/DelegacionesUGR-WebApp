<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="float-start image">
            <img src="<?php echo $_SESSION["foto"]; ?>" class="rounded-circle" alt="User Image" />
        </div>
        <div class="float-start info">
            <br>
            <p><?php echo $_SESSION["nom_compl"]; ?></p>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..." />
            <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li>
            <a href="/">
                <i class="fa fa-calendar"></i> <span>Calendario</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-table"></i> <span>Censo</span>
                <i class="fa fa-angle-left float-end"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="censo-actual.php"><i class="fa-regular fa-circle fa-xs"></i><span class="span-subbmenu">Actual</span></a></li>
                <li><a href="censo-areas.php"><i class="fa-regular fa-circle fa-xs"></i><span class="span-subbmenu">Areas</span></a></li>
                <li><a href="censo-historico.php"><i class="fa-regular fa-circle fa-xs"></i><span class="span-subbmenu">Histórico</span></a></li>
            </ul>
        </li>
        <li>
        <li class="treeview">
        <li class="treeview">
            <a href="#">
                <i class="fa fa-people-group"></i> <span>Plenos</span>
                <i class="fa fa-angle-left float-end"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="plenos-activos.php"><i class="fa-regular fa-circle fa-xs"></i>
                    <span class="span-subbmenu">Activos</span></a></li>
                <li><a href="plenos-historial.php"><i class="fa-regular fa-circle fa-xs"></i>
                    <span class="span-subbmenu">Historial</span></a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class="fa fa-tachometer"></i> <span>Sorteo</span></span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->