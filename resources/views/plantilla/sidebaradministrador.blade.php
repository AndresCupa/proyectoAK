
<div class="sidebar">
<div class="page-wrapper legacy-theme toggled">

<!-- <a id="toggle-sidebar" class="btn btn-sm btn-dark " href="#">
    <i class="icon-menu"></i>
</a> -->
<nav id="sidebar" class="sidebar-wrapper sidebar-nav">

    <div class="sidebar-content ">
        <div class="sidebar-brand">
            <!-- <a href="#">Software OYM</a> -->
            <!-- <button id="toggle-sidebar" class="navbar-toggler sidebar-toggler d-md-down-none" type="button"> -->
            <!-- <img src="img\Publiservicios.png" class="card-img-left" alt="Cinque Terre" width="50%" height="50%">  -->
            <h5>Software OYM</h5>
          <!-- <span class="navbar-toggler-icon"></span> -->
        </button>
        </div>
    <div class="sidebar-header">
        <div class="user-pic">
            <img class="img-avatar img-responsive img-rounded" src="img/avatars/6.png"
            alt="User picture">
        </div>
        <div class="user-info">
            <span class="user-name">
            <strong>{{Auth::user()->usuario}}</strong>
            </span>
            <span class="user-role">Administrator</span>
            <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
            </span>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li class="sidebar-dropdown ">
                <ul>
                    <li class="header-menu">
                        <span>TABLAS MAESTRAS</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="fas fa-cog"></i>
                            <span class="menu-text">General</span>                         
                        </a>
                        <div class="sidebar-submenu">
                        <ul>      
                                                      
                            <li @click="menu=4"  >
                                <a href="#"><i class="icon-bag"></i>Accesorio</a>                                                                               
                            </li>
                            <li @click="menu=62">
                                <a href="#"><i class="icon-bag"></i>Cargos</a>                                                                               
                            </li>                                
                          
                        </ul>                            
                        </div>                        
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="fas fa-clipboard"></i>
                            <span class="menu-text">Mantenimiento</span>                         
                        </a>
                        <div class="sidebar-submenu">
                            <ul>

                          
    
                       
                            <li @click="menu=79" >
                                <a  href="#"><i class="icon-bag"></i>Tp.</a>
                            </li>
                       
                            </ul>                            
                        </div>                        
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                            <i class="fas fa-clipboard-list"></i>
                            <span class="menu-text">Operación</span>                         
                        </a>
                        <div class="sidebar-submenu">
                            <ul>
                               
                                <li @click="menu=67" >
                                    <a  href="#"><i class="icon-user-following"></i>Detalle </a>
                                </li> 
                            </ul>                            
                        </div>                        
                    </li>
                    <li class="header-menu">
                        <span>MANTENIMIENTO</span>
                    </li>
                    <li class="sidebar-dropdown">
                        <a href="#">
                        <i class="far fa-newspaper"></i>
                            <span class="menu-text">Gestionar Fichas</span>
                        </a>                                        
                        <div class="sidebar-submenu">
                            <ul>

                                <li @click="menu=41" >
                                    <a  href="#"><i class="fas fa-laptop"></i>E. de Cómputo</a>
                                </li>
            
                            </ul>
                        </div>
                    </li>
   
                    <li class="header-menu">
                        <span>OPERACIÓN</span>
                    </li>
     
       
                    </li>
                        <li class="header-menu">
                            <span></span>
                         </li>

                
                </ul>
            </div>
    </div>
<div class="sidebar-footer">
  <a href="#">
    <i class="fa fa-bell"></i>
    <span class="badge badge-pill badge-warning notification">3</span>
  </a>
  <a href="#">
    <i class="fa fa-envelope"></i>
    <span class="badge badge-pill badge-success notification">7</span>
  </a>
  <a href="#">
    <i class="fa fa-cog"></i>
    <span class="badge-sonar"></span>
  </a>
  <div>
      
  </div>
  <a href="#">
    <i class="fa fa-power-off"></i>
  </a>
</div>
</nav>

 <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
</div>

