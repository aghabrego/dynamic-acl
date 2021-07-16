@extends('dynamicACL::layout')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @csrf
                @method('PATCH')

                <!-- role name -->
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <input type="text" placeholder="نام نقش را وارد کنید" name="name" class="form-control">
                            </div>
                        </div>
                        <!-- /col-md-4 -->

                        <div class="col col-md-4">
                            @if(auth()->user()->hasPermission('role.store'))
                                <div class="form-group"><input type="submit" class="btn btn-sm btn-rounded btn-success"
                                                               value="ایجاد نقش">
                                </div>
                            @endif
                        </div>
                        <!-- /col-md-4 -->

                    </div>
                    <!-- /role name -->

                    <div class="row">
                        <div class="col col-md-6">
                            <div class="card" style="margin-top:2%">
                                <div class="card-header text-center">
                                    دسترسی‌های پیشفرض
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <ul>
                                                <li>
                                                    <label>
                                                        <input type="checkbox"
                                                               name="access[fullAccess]"
                                                               {{ (isset($role->permissions['fullAccess']) && $role->permissions['fullAccess'] == 1) ? 'checked' : '' }}
                                                               value="1">
                                                        <span>دسترسی کامل</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($permissions as $key => $value)
                            <div class="col col-md-6">

                                <div class="card" style="margin-top:2%">

                                    <div class="card-header text-center">
                                        {{ str_replace('.', ' => ', $key) }}
                                    </div>
                                    <!-- /card header -->

                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-12">
                                                <ul style="column-count: 4; column-gap: 2rem; list-style: none; font-size: 13px;">
                                                    @foreach($value as $keyAccess)
                                                        <?php $check = isset($role->permissions[$key]); ?>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox"
                                                                       name="access[{{$key}}][{{$keyAccess['name']}}]"
                                                                       {{ $check ? 'checked' : '' }}
                                                                       value="1">
                                                                <span>{{ $keyAccess['name'] }}</span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <!-- /col-12 -->

                                        </div>
                                        <!-- /row -->


                                    </div>
                                    <!-- /card body -->

                                </div>
                                <!-- /card -->

                            </div>
                            <!-- /col-md-4 -->
                        @endforeach
                    </div>

                </form>
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
