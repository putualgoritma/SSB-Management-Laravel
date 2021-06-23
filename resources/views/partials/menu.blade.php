<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-book nav-icon">

                    </i>
                    {{ trans('global.pelajaran.title') }}
                </a>
                <ul class="nav-dropdown-items">               
                    
                    <li class="nav-item">
                        <a href="{{ route("admin.absents.schedule") }}" class="nav-link {{ request()->is('admin/absents') || request()->is('admin/absents/*') ? 'active' : '' }}">
                            <i class="fas fa-address-book nav-icon">

                            </i>
                            {{ trans('global.absent.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.bills.index") }}" class="nav-link {{ request()->is('admin/bills') || request()->is('admin/bills/*') ? 'active' : '' }}">
                            <i class="fas fa-money nav-icon">

                            </i>
                            {{ trans('global.bill.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.tests.index") }}" class="nav-link {{ request()->is('admin/tests') || request()->is('admin/tests/*') ? 'active' : '' }}">
                            <i class="fas fa-file-text nav-icon">

                            </i>
                            {{ trans('global.test.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.schedules.grades") }}" class="nav-link {{ request()->is('admin/schedules') || request()->is('admin/schedules/*') ? 'active' : '' }}">
                            <i class="fas fa-calendar nav-icon">

                            </i>
                            {{ trans('global.schedule.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-database  nav-icon">

                    </i>
                    {{ trans('global.master.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.periodes.index") }}" class="nav-link {{ request()->is('admin/periodes') || request()->is('admin/periodes/*') ? 'active' : '' }}">
                            <i class="fas fa-futbol-o nav-icon">

                            </i>
                            {{ trans('global.periode.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.students.index") }}" class="nav-link {{ request()->is('admin/student') || request()->is('admin/student/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.student.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.teachers.index") }}" class="nav-link {{ request()->is('admin/teacher') || request()->is('admin/teacher/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.teacher.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.teams.index") }}" class="nav-link {{ request()->is('admin/team') || request()->is('admin/team/*') ? 'active' : '' }}">
                            <i class="fas fa-futbol-o nav-icon">

                            </i>
                            {{ trans('global.team.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.grades.index") }}" class="nav-link {{ request()->is('admin/grades') || request()->is('admin/grades/*') ? 'active' : '' }}">
                            <i class="fas fa-futbol-o nav-icon">

                            </i>
                            {{ trans('global.grade.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.semesters.index") }}" class="nav-link {{ request()->is('admin/semesters') || request()->is('admin/semesters/*') ? 'active' : '' }}">
                            <i class="fas fa-futbol-o nav-icon">

                            </i>
                            {{ trans('global.semester.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.subjects.index") }}" class="nav-link {{ request()->is('admin/subjects') || request()->is('admin/subjects/*') ? 'active' : '' }}">
                            <i class="fas fa-book-reader nav-icon">

                            </i>
                            {{ trans('global.subject.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-users nav-icon">

                    </i>
                    {{ trans('global.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>            
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>