    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{$user->profile_picture != ''?asset('images/'.$user->profile_picture):asset('no_pic.png')}}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{$user->firstname}} {{$user->lastname}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- search form -->
        <!--form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form-->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
            <li id="Dashboard">
            <a href="{{route('home')}}">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>

          <!--Preregistration-->
          <li id="preregmenu">
            <a href="{{route('selfassess')}}">
              <i class="fa fa-edit" aria-hidden="true"></i> <span>Assess</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
          <!--Preregistration-->

          <!--Accounts-->
          <li class="treeview" id="accountsmenu">
            <a href="#">
              <i class="fa fa-credit-card" aria-hidden="true"></i>
              <span>Accounts</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="accountDetails"><a href="{{route('accountDetails')}}"><i class="fa fa-circle-o"></i>Account Details</a></li>
              <li id="transHistory"><a href="{{url('account/transactionhistory')}}"><i class="fa fa-circle-o"></i> Transaction History</a></li>
            </ul>
          </li>
          <!--Accounts-->

          <!--Grades-->
          <li id="gradesmenu">
            <a href="{{route('grade')}}">
              <i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Grades</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green">available</small>
              </span>
            </a>
          </li>
          <!--Grades-->
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>