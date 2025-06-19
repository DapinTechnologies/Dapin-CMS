<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.siteinfo')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block row">
                        
                        <!-- Form Start -->
                        <input name="id" type="hidden" value="<?php echo e((isset($row->id))?$row->id:-1); ?>">

                        <div class="form-group col-md-6">
                            <label for="title"><?php echo e(__('field_site_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(isset($row->title)?$row->title:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_site_title')); ?>

                            </div>
                        </div>

                        

                        <div class="form-group col-md-6">
                            <label for="meta_title"><?php echo e(__('field_meta_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo e(isset($row->meta_title)?$row->meta_title:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_meta_title')); ?>

                            </div>
                        </div>

                        <hr/>

                        <div class="form-group col-md-6">
                            <label for="meta_description"><?php echo e(__('field_meta_description')); ?>: <span><?php echo e(__('field_meta_desc_length')); ?></span></label>
                            <textarea class="form-control" name="meta_description" id="meta_description"><?php echo e(isset($row->meta_description)?$row->meta_description:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_meta_description')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="meta_keywords"><?php echo e(__('field_meta_keywords')); ?>: <span><?php echo e(__('field_keywords_separate')); ?></span></label>
                            <textarea class="form-control" name="meta_keywords" id="meta_keywords"><?php echo e(isset($row->meta_keywords)?$row->meta_keywords:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_meta_keywords')); ?>

                            </div>
                        </div>

                        <hr/>

                        <div class="form-group col-md-6">

                            <?php if(isset($row->logo_path)): ?>
                            <?php if(is_file('uploads/'.$path.'/'.$row->logo_path)): ?>
                            <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->logo_path)); ?>" class="img-fluid setting-image" alt="<?php echo e(__('field_site_logo')); ?>">
                            <div class="clearfix"></div>
                            <?php endif; ?>
                            <?php endif; ?>

                            <label for="logo"><?php echo e(__('field_site_logo')); ?>: <span><?php echo e(__('image_size', ['height' => 200, 'width' => 'Any'])); ?></span></label>
                            <input type="file" class="form-control" name="logo" id="logo">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_site_logo')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">

                            <?php if(isset($row->favicon_path)): ?>
                            <?php if(is_file('uploads/'.$path.'/'.$row->favicon_path)): ?>
                            <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->favicon_path)); ?>" class="img-fluid setting-image" alt="<?php echo e(__('field_site_favicon')); ?>">
                            <div class="clearfix"></div>
                            <?php endif; ?>
                            <?php endif; ?>

                            <label for="favicon"><?php echo e(__('field_site_favicon')); ?>: <span><?php echo e(__('image_size', ['height' => 64, 'width' => 64])); ?></span></label>
                            <input type="file" class="form-control" name="favicon" id="favicon">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_site_favicon')); ?>

                            </div>
                        </div>

                        <hr/>

                        <?php if(isset($row->date_format)): ?>
                        <div class="form-group col-md-4">
                            <label for="date_format"><?php echo e(__('field_date_format')); ?> <span>*</span></label>
                            <select class="form-control" name="date_format" id="date_format" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="d-m-Y" <?php if( $row->date_format == 'd-m-Y' ): ?> selected <?php endif; ?>>DD-MM-YYYY</option>
                                <option value="m-d-Y" <?php if( $row->date_format == 'm-d-Y' ): ?> selected <?php endif; ?>>MM-DD-YYYY</option>
                                <option value="Y-m-d" <?php if( $row->date_format == 'Y-m-d' ): ?> selected <?php endif; ?>>YYYY-MM-DD</option>
                                <option value="d/m/Y" <?php if( $row->date_format == 'd/m/Y' ): ?> selected <?php endif; ?>>DD/MM/YYYY</option>
                                <option value="m/d/Y" <?php if( $row->date_format == 'm/d/Y' ): ?> selected <?php endif; ?>>MM/DD/YYYY</option>
                                <option value="Y/m/d" <?php if( $row->date_format == 'Y/m/d' ): ?> selected <?php endif; ?>>YYYY/MM/DD</option>
                                <option value="d.m.Y" <?php if( $row->date_format == 'd.m.Y' ): ?> selected <?php endif; ?>>DD.MM.YYYY</option>
                                <option value="m.d.Y" <?php if( $row->date_format == 'm.d.Y' ): ?> selected <?php endif; ?>>MM.DD.YYYY</option>
                                <option value="Y.m.d" <?php if( $row->date_format == 'Y.m.d' ): ?> selected <?php endif; ?>>YYYY.MM.DD</option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_date_format')); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        

                        <?php if(isset($row->time_format)): ?>
                        <div class="form-group col-md-4">
                            <label for="time_format"><?php echo e(__('field_time_format')); ?> <span>*</span></label>
                            <select class="form-control" name="time_format" id="time_format" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="h:i:s" <?php if( $row->time_format == 'h:i:s' ): ?> selected <?php endif; ?>><?php echo e(__('HH:MM:SS')); ?></option>
                                <option value="h:i:s A" <?php if( $row->time_format == 'h:i:s A' ): ?> selected <?php endif; ?>><?php echo e(__('HH:MM:SS XM')); ?></option>
                                <option value="h:i" <?php if( $row->time_format == 'h:i' ): ?> selected <?php endif; ?>><?php echo e(__(('HH:MM'))); ?></option>
                                <option value="h:i A" <?php if( $row->time_format == 'h:i A' ): ?> selected <?php endif; ?>><?php echo e(__('HH:MM XM')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_time_format')); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if(isset($row->time_zone)): ?>
                        <div class="form-group col-md-4">
                            <label for="time_zone"><?php echo e(__('field_time_zone')); ?> <span>*</span></label>
                            <select class="form-control" name="time_zone" id="time_zone" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="Pacific/Midway" <?php if( $row->time_zone == 'Pacific/Midway' ): ?> selected <?php endif; ?>>(GMT-11:00) Pacific, Midway</option>
                                <option value="Pacific/Niue" <?php if( $row->time_zone == 'Pacific/Niue' ): ?> selected <?php endif; ?>>(GMT-11:00) Pacific, Niue</option>
                                <option value="Pacific/Pago_Pago" <?php if( $row->time_zone == 'Pacific/Pago_Pago' ): ?> selected <?php endif; ?>>(GMT-11:00) Pacific, Pago Pago</option>
                                <option value="Pacific/Honolulu" <?php if( $row->time_zone == 'Pacific/Honolulu' ): ?> selected <?php endif; ?>>(GMT-10:00) Pacific, Honolulu</option>
                                <option value="Pacific/Rarotonga" <?php if( $row->time_zone == 'Pacific/Rarotonga' ): ?> selected <?php endif; ?>>(GMT-10:00) Pacific, Rarotonga</option>
                                <option value="Pacific/Tahiti" <?php if( $row->time_zone == 'Pacific/Tahiti' ): ?> selected <?php endif; ?>>(GMT-10:00) Pacific, Tahiti</option>
                                <option value="Pacific/Marquesas" <?php if( $row->time_zone == 'Pacific/Marquesas' ): ?> selected <?php endif; ?>>(GMT-09:30) Pacific, Marquesas</option>
                                <option value="America/Adak" <?php if( $row->time_zone == 'America/Adak' ): ?> selected <?php endif; ?>>(GMT-09:00) America, Adak</option>
                                <option value="Pacific/Gambier" <?php if( $row->time_zone == 'Pacific/Gambier' ): ?> selected <?php endif; ?>>(GMT-09:00) Pacific, Gambier</option>
                                <option value="America/Anchorage" <?php if( $row->time_zone == 'America/Anchorage' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Anchorage</option>
                                <option value="America/Juneau" <?php if( $row->time_zone == 'America/Juneau' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Juneau</option>
                                <option value="America/Metlakatla" <?php if( $row->time_zone == 'America/Metlakatla' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Metlakatla</option>
                                <option value="America/Nome" <?php if( $row->time_zone == 'America/Nome' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Nome</option>
                                <option value="America/Sitka" <?php if( $row->time_zone == 'America/Sitka' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Sitka</option>
                                <option value="America/Yakutat" <?php if( $row->time_zone == 'America/Yakutat' ): ?> selected <?php endif; ?>>(GMT-08:00) America, Yakutat</option>
                                <option value="Pacific/Pitcairn" <?php if( $row->time_zone == 'Pacific/Pitcairn' ): ?> selected <?php endif; ?>>(GMT-08:00) Pacific, Pitcairn</option>
                                <option value="America/Creston" <?php if( $row->time_zone == 'America/Creston' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Creston</option>
                                <option value="America/Dawson" <?php if( $row->time_zone == 'America/Dawson' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Dawson</option>
                                <option value="America/Dawson_Creek" <?php if( $row->time_zone == 'America/Dawson_Creek' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Dawson Creek</option>
                                <option value="America/Fort_Nelson" <?php if( $row->time_zone == 'America/Fort_Nelson' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Fort Nelson</option>
                                <option value="America/Hermosillo" <?php if( $row->time_zone == 'America/Hermosillo' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Hermosillo</option>
                                <option value="America/Los_Angeles" <?php if( $row->time_zone == 'America/Los_Angeles' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Los Angeles</option>
                                <option value="America/Phoenix" <?php if( $row->time_zone == 'America/Phoenix' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Phoenix</option>
                                <option value="America/Tijuana" <?php if( $row->time_zone == 'America/Tijuana' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Tijuana</option>
                                <option value="America/Vancouver" <?php if( $row->time_zone == 'America/Vancouver' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Vancouver</option>
                                <option value="America/Whitehorse" <?php if( $row->time_zone == 'America/Whitehorse' ): ?> selected <?php endif; ?>>(GMT-07:00) America, Whitehorse</option>
                                <option value="America/Belize" <?php if( $row->time_zone == 'America/Belize' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Belize</option>
                                <option value="America/Boise" <?php if( $row->time_zone == 'America/Boise' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Boise</option>
                                <option value="America/Cambridge_Bay" <?php if( $row->time_zone == 'America/Cambridge_Bay' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Cambridge Bay</option>
                                <option value="America/Chihuahua" <?php if( $row->time_zone == 'America/Chihuahua' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Chihuahua</option>
                                <option value="America/Costa_Rica" <?php if( $row->time_zone == 'America/Costa_Rica' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Costa Rica</option>
                                <option value="America/Denver" <?php if( $row->time_zone == 'America/Denver' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Denver</option>
                                <option value="America/Edmonton" <?php if( $row->time_zone == 'America/Edmonton' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Edmonton</option>
                                <option value="America/El_Salvador" <?php if( $row->time_zone == 'America/El_Salvador' ): ?> selected <?php endif; ?>>(GMT-06:00) America, El Salvador</option>
                                <option value="America/Guatemala" <?php if( $row->time_zone == 'America/Guatemala' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Guatemala</option>
                                <option value="America/Inuvik" <?php if( $row->time_zone == 'America/Inuvik' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Inuvik</option>
                                <option value="America/Managua" <?php if( $row->time_zone == 'America/Managua' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Managua</option>
                                <option value="America/Mazatlan" <?php if( $row->time_zone == 'America/Mazatlan' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Mazatlan</option>
                                <option value="America/Ojinaga" <?php if( $row->time_zone == 'America/Ojinaga' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Ojinaga</option>
                                <option value="America/Regina" <?php if( $row->time_zone == 'America/Regina' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Regina</option>
                                <option value="America/Swift_Current" <?php if( $row->time_zone == 'America/Swift_Current' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Swift Current</option>
                                <option value="America/Tegucigalpa" <?php if( $row->time_zone == 'America/Tegucigalpa' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Tegucigalpa</option>
                                <option value="America/Yellowknife" <?php if( $row->time_zone == 'America/Yellowknife' ): ?> selected <?php endif; ?>>(GMT-06:00) America, Yellowknife</option>
                                <option value="Pacific/Easter" <?php if( $row->time_zone == 'Pacific/Easter' ): ?> selected <?php endif; ?>>(GMT-06:00) Pacific, Easter</option>
                                <option value="Pacific/Galapagos" <?php if( $row->time_zone == 'Pacific/Galapagos' ): ?> selected <?php endif; ?>>(GMT-06:00) Pacific, Galapagos</option>
                                <option value="America/Atikokan" <?php if( $row->time_zone == 'America/Atikokan' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Atikokan</option>
                                <option value="America/Bahia_Banderas" <?php if( $row->time_zone == 'America/Bahia_Banderas' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Bahia Banderas</option>
                                <option value="America/Bogota" <?php if( $row->time_zone == 'America/Bogota' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Bogota</option>
                                <option value="America/Cancun" <?php if( $row->time_zone == 'America/Cancun' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Cancun</option>
                                <option value="America/Cayman" <?php if( $row->time_zone == 'America/Cayman' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Cayman</option>
                                <option value="America/Chicago" <?php if( $row->time_zone == 'America/Chicago' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Chicago</option>
                                <option value="America/Eirunepe" <?php if( $row->time_zone == 'America/Eirunepe' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Eirunepe</option>
                                <option value="America/Guayaquil" <?php if( $row->time_zone == 'America/Guayaquil' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Guayaquil</option>
                                <option value="America/Indiana/Knox" <?php if( $row->time_zone == 'America/Indiana/Knox' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Indiana, Knox</option>
                                <option value="America/Indiana/Tell_City" <?php if( $row->time_zone == 'America/Indiana/Tell_City' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Indiana, Tell City</option>
                                <option value="America/Jamaica" <?php if( $row->time_zone == 'America/Jamaica' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Jamaica</option>
                                <option value="America/Lima" <?php if( $row->time_zone == 'America/Lima' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Lima</option>
                                <option value="America/Matamoros" <?php if( $row->time_zone == 'America/Matamoros' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Matamoros</option>
                                <option value="America/Menominee" <?php if( $row->time_zone == 'America/Menominee' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Menominee</option>
                                <option value="America/Merida" <?php if( $row->time_zone == 'America/Merida' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Merida</option>
                                <option value="America/Mexico_City" <?php if( $row->time_zone == 'America/Mexico_City' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Mexico City</option>
                                <option value="America/Monterrey" <?php if( $row->time_zone == 'America/Monterrey' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Monterrey</option>
                                <option value="America/North_Dakota/Beulah" <?php if( $row->time_zone == 'America/North_Dakota/Beulah' ): ?> selected <?php endif; ?>>(GMT-05:00) America, North Dakota, Beulah</option>
                                <option value="America/North_Dakota/Center" <?php if( $row->time_zone == 'America/North_Dakota/Center' ): ?> selected <?php endif; ?>>(GMT-05:00) America, North Dakota, Center</option>
                                <option value="America/North_Dakota/New_Salem" <?php if( $row->time_zone == 'America/North_Dakota/New_Salem' ): ?> selected <?php endif; ?>>(GMT-05:00) America, North Dakota, New Salem</option>
                                <option value="America/Panama" <?php if( $row->time_zone == 'America/Panama' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Panama</option>
                                <option value="America/Rainy_River" <?php if( $row->time_zone == 'America/Rainy_River' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Rainy River</option>
                                <option value="America/Rankin_Inlet" <?php if( $row->time_zone == 'America/Rankin_Inlet' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Rankin Inlet</option>
                                <option value="America/Resolute" <?php if( $row->time_zone == 'America/Resolute' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Resolute</option>
                                <option value="America/Rio_Branco" <?php if( $row->time_zone == 'America/Rio_Branco' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Rio Branco</option>
                                <option value="America/Winnipeg" <?php if( $row->time_zone == 'America/Winnipeg' ): ?> selected <?php endif; ?>>(GMT-05:00) America, Winnipeg</option>
                                <option value="America/Anguilla" <?php if( $row->time_zone == 'America/Anguilla' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Anguilla</option>
                                <option value="America/Antigua" <?php if( $row->time_zone == 'America/Antigua' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Antigua</option>
                                <option value="America/Aruba" <?php if( $row->time_zone == 'America/Aruba' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Aruba</option>
                                <option value="America/Asuncion" <?php if( $row->time_zone == 'America/Asuncion' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Asuncion</option>
                                <option value="America/Barbados" <?php if( $row->time_zone == 'America/Barbados' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Barbados</option>
                                <option value="America/Blanc-Sablon" <?php if( $row->time_zone == 'America/Blanc-Sablon' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Blanc-Sablon</option>
                                <option value="America/Boa_Vista" <?php if( $row->time_zone == 'America/Boa_Vista' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Boa Vista</option>
                                <option value="America/Campo_Grande" <?php if( $row->time_zone == 'America/Campo_Grande' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Campo Grande</option>
                                <option value="America/Caracas" <?php if( $row->time_zone == 'America/Caracas' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Caracas</option>
                                <option value="America/Cuiaba" <?php if( $row->time_zone == 'America/Cuiaba' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Cuiaba</option>
                                <option value="America/Curacao" <?php if( $row->time_zone == 'America/Curacao' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Curacao</option>
                                <option value="America/Detroit" <?php if( $row->time_zone == 'America/Detroit' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Detroit</option>
                                <option value="America/Dominica" <?php if( $row->time_zone == 'America/Dominica' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Dominica</option>
                                <option value="America/Grand_Turk" <?php if( $row->time_zone == 'America/Grand_Turk' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Grand Turk</option>
                                <option value="America/Grenada" <?php if( $row->time_zone == 'America/Grenada' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Grenada</option>
                                <option value="America/Guadeloupe" <?php if( $row->time_zone == 'America/Guadeloupe' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Guadeloupe</option>
                                <option value="America/Guyana" <?php if( $row->time_zone == 'America/Guyana' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Guyana</option>
                                <option value="America/Havana" <?php if( $row->time_zone == 'America/Havana' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Havana</option>
                                <option value="America/Indiana/Indianapolis" <?php if( $row->time_zone == 'America/Indiana/Indianapolis' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Indianapolis</option>
                                <option value="America/Indiana/Marengo" <?php if( $row->time_zone == 'America/Indiana/Marengo' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Marengo</option>
                                <option value="America/Indiana/Petersburg" <?php if( $row->time_zone == 'America/Indiana/Petersburg' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Petersburg</option>
                                <option value="America/Indiana/Vevay" <?php if( $row->time_zone == 'America/Indiana/Vevay' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Vevay</option>
                                <option value="America/Indiana/Vincennes" <?php if( $row->time_zone == 'America/Indiana/Vincennes' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Vincennes</option>
                                <option value="America/Indiana/Winamac" <?php if( $row->time_zone == 'America/Indiana/Winamac' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Indiana, Winamac</option>
                                <option value="America/Iqaluit" <?php if( $row->time_zone == 'America/Iqaluit' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Iqaluit</option>
                                <option value="America/Kentucky/Louisville" <?php if( $row->time_zone == 'America/Kentucky/Louisville' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Kentucky, Louisville</option>
                                <option value="America/Kentucky/Monticello" <?php if( $row->time_zone == 'America/Kentucky/Monticello' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Kentucky, Monticello</option>
                                <option value="America/Kralendijk" <?php if( $row->time_zone == 'America/Kralendijk' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Kralendijk</option>
                                <option value="America/La_Paz" <?php if( $row->time_zone == 'America/La_Paz' ): ?> selected <?php endif; ?>>(GMT-04:00) America, La Paz</option>
                                <option value="America/Lower_Princes" <?php if( $row->time_zone == 'America/Lower_Princes' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Lower Princes</option>
                                <option value="America/Manaus" <?php if( $row->time_zone == 'America/Manaus' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Manaus</option>
                                <option value="America/Marigot" <?php if( $row->time_zone == 'America/Marigot' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Marigot</option>
                                <option value="America/Martinique" <?php if( $row->time_zone == 'America/Martinique' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Martinique</option>
                                <option value="America/Montserrat" <?php if( $row->time_zone == 'America/Montserrat' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Montserrat</option>
                                <option value="America/Nassau" <?php if( $row->time_zone == 'America/Nassau' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Nassau</option>
                                <option value="America/New_York" <?php if( $row->time_zone == 'America/New_York' ): ?> selected <?php endif; ?>>(GMT-04:00) America, New York</option>
                                <option value="America/Nipigon" <?php if( $row->time_zone == 'America/Nipigon' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Nipigon</option>
                                <option value="America/Pangnirtung" <?php if( $row->time_zone == 'America/Pangnirtung' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Pangnirtung</option>
                                <option value="America/Port_of_Spain" <?php if( $row->time_zone == 'America/Port_of_Spain' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Port of Spain</option>
                                <option value="America/Port-au-Prince" <?php if( $row->time_zone == 'America/Port-au-Prince' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Port-au-Prince</option>
                                <option value="America/Porto_Velho" <?php if( $row->time_zone == 'America/Porto_Velho' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Porto Velho</option>
                                <option value="America/Puerto_Rico" <?php if( $row->time_zone == 'America/Puerto_Rico' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Puerto Rico</option>
                                <option value="America/Santiago" <?php if( $row->time_zone == 'America/Santiago' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Santiago</option>
                                <option value="America/Santo_Domingo" <?php if( $row->time_zone == 'America/Santo_Domingo' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Santo Domingo</option>
                                <option value="America/St_Barthelemy" <?php if( $row->time_zone == 'America/St_Barthelemy' ): ?> selected <?php endif; ?>>(GMT-04:00) America, St. Barthelemy</option>
                                <option value="America/St_Kitts" <?php if( $row->time_zone == 'America/St_Kitts' ): ?> selected <?php endif; ?>>(GMT-04:00) America, St. Kitts</option>
                                <option value="America/St_Lucia" <?php if( $row->time_zone == 'America/St_Lucia' ): ?> selected <?php endif; ?>>(GMT-04:00) America, St. Lucia</option>
                                <option value="America/St_Thomas" <?php if( $row->time_zone == 'America/St_Thomas' ): ?> selected <?php endif; ?>>(GMT-04:00) America, St. Thomas</option>
                                <option value="America/St_Vincent" <?php if( $row->time_zone == 'America/St_Vincent' ): ?> selected <?php endif; ?>>(GMT-04:00) America, St. Vincent</option>
                                <option value="America/Thunder_Bay" <?php if( $row->time_zone == 'America/Thunder_Bay' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Thunder Bay</option>
                                <option value="America/Toronto" <?php if( $row->time_zone == 'America/Toronto' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Toronto</option>
                                <option value="America/Tortola" <?php if( $row->time_zone == 'America/Tortola' ): ?> selected <?php endif; ?>>(GMT-04:00) America, Tortola</option>
                                <option value="America/Araguaina" <?php if( $row->time_zone == 'America/Araguaina' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Araguaina</option>
                                <option value="America/Argentina/Buenos_Aires" <?php if( $row->time_zone == 'America/Argentina/Buenos_Aires' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Buenos Aires</option>
                                <option value="America/Argentina/Catamarca" <?php if( $row->time_zone == 'America/Argentina/Catamarca' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Catamarca</option>
                                <option value="America/Argentina/Cordoba" <?php if( $row->time_zone == 'America/Argentina/Cordoba' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Cordoba</option>
                                <option value="America/Argentina/Jujuy" <?php if( $row->time_zone == 'America/Argentina/Jujuy' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Jujuy</option>
                                <option value="America/Argentina/La_Rioja" <?php if( $row->time_zone == 'America/Argentina/La_Rioja' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, La Rioja</option>
                                <option value="America/Argentina/Mendoza" <?php if( $row->time_zone == 'America/Argentina/Mendoza' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Mendoza</option>
                                <option value="America/Argentina/Rio_Gallegos" <?php if( $row->time_zone == 'America/Argentina/Rio_Gallegos' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Rio Gallegos</option>
                                <option value="America/Argentina/Salta" <?php if( $row->time_zone == 'America/Argentina/Salta' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Salta</option>
                                <option value="America/Argentina/San_Juan" <?php if( $row->time_zone == 'America/Argentina/San_Juan' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, San Juan</option>
                                <option value="America/Argentina/San_Luis" <?php if( $row->time_zone == 'America/Argentina/San_Luis' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, San Luis</option>
                                <option value="America/Argentina/Tucuman" <?php if( $row->time_zone == 'America/Argentina/Tucuman' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Tucuman</option>
                                <option value="America/Argentina/Ushuaia" <?php if( $row->time_zone == 'America/Argentina/Ushuaia' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Argentina, Ushuaia</option>
                                <option value="America/Bahia" <?php if( $row->time_zone == 'America/Bahia' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Bahia</option>
                                <option value="America/Belem" <?php if( $row->time_zone == 'America/Belem' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Belem</option>
                                <option value="America/Cayenne" <?php if( $row->time_zone == 'America/Cayenne' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Cayenne</option>
                                <option value="America/Fortaleza" <?php if( $row->time_zone == 'America/Fortaleza' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Fortaleza</option>
                                <option value="America/Glace_Bay" <?php if( $row->time_zone == 'America/Glace_Bay' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Glace Bay</option>
                                <option value="America/Goose_Bay" <?php if( $row->time_zone == 'America/Goose_Bay' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Goose Bay</option>
                                <option value="America/Halifax" <?php if( $row->time_zone == 'America/Halifax' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Halifax</option>
                                <option value="America/Maceio" <?php if( $row->time_zone == 'America/Maceio' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Maceio</option>
                                <option value="America/Moncton" <?php if( $row->time_zone == 'America/Moncton' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Moncton</option>
                                <option value="America/Montevideo" <?php if( $row->time_zone == 'America/Montevideo' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Montevideo</option>
                                <option value="America/Paramaribo" <?php if( $row->time_zone == 'America/Paramaribo' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Paramaribo</option>
                                <option value="America/Punta_Arenas" <?php if( $row->time_zone == 'America/Punta_Arenas' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Punta Arenas</option>
                                <option value="America/Recife" <?php if( $row->time_zone == 'America/Recife' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Recife</option>
                                <option value="America/Santarem" <?php if( $row->time_zone == 'America/Santarem' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Santarem</option>
                                <option value="America/Sao_Paulo" <?php if( $row->time_zone == 'America/Sao_Paulo' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Sao Paulo</option>
                                <option value="America/Thule" <?php if( $row->time_zone == 'America/Thule' ): ?> selected <?php endif; ?>>(GMT-03:00) America, Thule</option>
                                <option value="Antarctica/Palmer" <?php if( $row->time_zone == 'Antarctica/Palmer' ): ?> selected <?php endif; ?>>(GMT-03:00) Antarctica, Palmer</option>
                                <option value="Antarctica/Rothera" <?php if( $row->time_zone == 'Antarctica/Rothera' ): ?> selected <?php endif; ?>>(GMT-03:00) Antarctica, Rothera</option>
                                <option value="Atlantic/Bermuda" <?php if( $row->time_zone == 'Atlantic/Bermuda' ): ?> selected <?php endif; ?>>(GMT-03:00) Atlantic, Bermuda</option>
                                <option value="Atlantic/Stanley" <?php if( $row->time_zone == 'Atlantic/Stanley' ): ?> selected <?php endif; ?>>(GMT-03:00) Atlantic, Stanley</option>
                                <option value="America/St_Johns" <?php if( $row->time_zone == 'America/St_Johns' ): ?> selected <?php endif; ?>>(GMT-02:30) America, St. Johns</option>
                                <option value="America/Godthab" <?php if( $row->time_zone == 'America/Godthab' ): ?> selected <?php endif; ?>>(GMT-02:00) America, Godthab</option>
                                <option value="America/Miquelon" <?php if( $row->time_zone == 'America/Miquelon' ): ?> selected <?php endif; ?>>(GMT-02:00) America, Miquelon</option>
                                <option value="America/Noronha" <?php if( $row->time_zone == 'America/Noronha' ): ?> selected <?php endif; ?>>(GMT-02:00) America, Noronha</option>
                                <option value="Atlantic/South_Georgia" <?php if( $row->time_zone == 'Atlantic/South_Georgia' ): ?> selected <?php endif; ?>>(GMT-02:00) Atlantic, South Georgia</option>
                                <option value="Atlantic/Cape_Verde" <?php if( $row->time_zone == 'Atlantic/Cape_Verde' ): ?> selected <?php endif; ?>>(GMT-01:00) Atlantic, Cape Verde</option>
                                <option value="Africa/Abidjan" <?php if( $row->time_zone == 'Africa/Abidjan' ): ?> selected <?php endif; ?>>(GMT) Africa, Abidjan</option>
                                <option value="Africa/Accra" <?php if( $row->time_zone == 'Africa/Accra' ): ?> selected <?php endif; ?>>(GMT) Africa, Accra</option>
                                <option value="Africa/Bamako" <?php if( $row->time_zone == 'Africa/Bamako' ): ?> selected <?php endif; ?>>(GMT) Africa, Bamako</option>
                                <option value="Africa/Banjul" <?php if( $row->time_zone == 'Africa/Banjul' ): ?> selected <?php endif; ?>>(GMT) Africa, Banjul</option>
                                <option value="Africa/Bissau" <?php if( $row->time_zone == 'Africa/Bissau' ): ?> selected <?php endif; ?>>(GMT) Africa, Bissau</option>
                                <option value="Africa/Conakry" <?php if( $row->time_zone == 'Africa/Conakry' ): ?> selected <?php endif; ?>>(GMT) Africa, Conakry</option>
                                <option value="Africa/Dakar" <?php if( $row->time_zone == 'Africa/Dakar' ): ?> selected <?php endif; ?>>(GMT) Africa, Dakar</option>
                                <option value="Africa/Freetown" <?php if( $row->time_zone == 'Africa/Freetown' ): ?> selected <?php endif; ?>>(GMT) Africa, Freetown</option>
                                <option value="Africa/Lome" <?php if( $row->time_zone == 'Africa/Lome' ): ?> selected <?php endif; ?>>(GMT) Africa, Lome</option>
                                <option value="Africa/Monrovia" <?php if( $row->time_zone == 'Africa/Monrovia' ): ?> selected <?php endif; ?>>(GMT) Africa, Monrovia</option>
                                <option value="Africa/Nouakchott" <?php if( $row->time_zone == 'Africa/Nouakchott' ): ?> selected <?php endif; ?>>(GMT) Africa, Nouakchott</option>
                                <option value="Africa/Ouagadougou" <?php if( $row->time_zone == 'Africa/Ouagadougou' ): ?> selected <?php endif; ?>>(GMT) Africa, Ouagadougou</option>
                                <option value="Africa/Sao_Tome" <?php if( $row->time_zone == 'Africa/Sao_Tome' ): ?> selected <?php endif; ?>>(GMT) Africa, Sao Tome</option>
                                <option value="America/Danmarkshavn" <?php if( $row->time_zone == 'America/Danmarkshavn' ): ?> selected <?php endif; ?>>(GMT) America, Danmarkshavn</option>
                                <option value="America/Scoresbysund" <?php if( $row->time_zone == 'America/Scoresbysund' ): ?> selected <?php endif; ?>>(GMT) America, Scoresbysund</option>
                                <option value="Atlantic/Azores" <?php if( $row->time_zone == 'Atlantic/Azores' ): ?> selected <?php endif; ?>>(GMT) Atlantic, Azores</option>
                                <option value="Atlantic/Reykjavik" <?php if( $row->time_zone == 'Atlantic/Reykjavik' ): ?> selected <?php endif; ?>>(GMT) Atlantic, Reykjavik</option>
                                <option value="Atlantic/St_Helena" <?php if( $row->time_zone == 'Atlantic/St_Helena' ): ?> selected <?php endif; ?>>(GMT) Atlantic, St. Helena</option>
                                <option value="UTC" <?php if( $row->time_zone == 'UTC' ): ?> selected <?php endif; ?>>(GMT) UTC</option>
                                <option value="Africa/Algiers" <?php if( $row->time_zone == 'Africa/Algiers' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Algiers</option>
                                <option value="Africa/Bangui" <?php if( $row->time_zone == 'Africa/Bangui' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Bangui</option>
                                <option value="Africa/Brazzaville" <?php if( $row->time_zone == 'Africa/Brazzaville' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Brazzaville</option>
                                <option value="Africa/Casablanca" <?php if( $row->time_zone == 'Africa/Casablanca' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Casablanca</option>
                                <option value="Africa/Douala" <?php if( $row->time_zone == 'Africa/Douala' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Douala</option>
                                <option value="Africa/El_Aaiun" <?php if( $row->time_zone == 'Africa/El_Aaiun' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, El Aaiun</option>
                                <option value="Africa/Kinshasa" <?php if( $row->time_zone == 'Africa/Kinshasa' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Kinshasa</option>
                                <option value="Africa/Lagos" <?php if( $row->time_zone == 'Africa/Lagos' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Lagos</option>
                                <option value="Africa/Libreville" <?php if( $row->time_zone == 'Africa/Libreville' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Libreville</option>
                                <option value="Africa/Luanda" <?php if( $row->time_zone == 'Africa/Luanda' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Luanda</option>
                                <option value="Africa/Malabo" <?php if( $row->time_zone == 'Africa/Malabo' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Malabo</option>
                                <option value="Africa/Ndjamena" <?php if( $row->time_zone == 'Africa/Ndjamena' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Ndjamena</option>
                                <option value="Africa/Niamey" <?php if( $row->time_zone == 'Africa/Niamey' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Niamey</option>
                                <option value="Africa/Porto-Novo" <?php if( $row->time_zone == 'Africa/Porto-Novo' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Porto-Novo</option>
                                <option value="Africa/Tunis" <?php if( $row->time_zone == 'Africa/Tunis' ): ?> selected <?php endif; ?>>(GMT+01:00) Africa, Tunis</option>
                                <option value="Atlantic/Canary" <?php if( $row->time_zone == 'Atlantic/Canary' ): ?> selected <?php endif; ?>>(GMT+01:00) Atlantic, Canary</option>
                                <option value="Atlantic/Faroe" <?php if( $row->time_zone == 'Atlantic/Faroe' ): ?> selected <?php endif; ?>>(GMT+01:00) Atlantic, Faroe</option>
                                <option value="Atlantic/Madeira" <?php if( $row->time_zone == 'Atlantic/Madeira' ): ?> selected <?php endif; ?>>(GMT+01:00) Atlantic, Madeira</option>
                                <option value="Europe/Dublin" <?php if( $row->time_zone == 'Europe/Dublin' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, Dublin</option>
                                <option value="Europe/Guernsey" <?php if( $row->time_zone == 'Europe/Guernsey' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, Guernsey</option>
                                <option value="Europe/Isle_of_Man" <?php if( $row->time_zone == 'Europe/Isle_of_Man' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, Isle of Man</option>
                                <option value="Europe/Jersey" <?php if( $row->time_zone == 'Europe/Jersey' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, Jersey</option>
                                <option value="Europe/Lisbon" <?php if( $row->time_zone == 'Europe/Lisbon' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, Lisbon</option>
                                <option value="Europe/London" <?php if( $row->time_zone == 'Europe/London' ): ?> selected <?php endif; ?>>(GMT+01:00) Europe, London</option>
                                <option value="Africa/Blantyre" <?php if( $row->time_zone == 'Africa/Blantyre' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Blantyre</option>
                                <option value="Africa/Bujumbura" <?php if( $row->time_zone == 'Africa/Bujumbura' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Bujumbura</option>
                                <option value="Africa/Cairo" <?php if( $row->time_zone == 'Africa/Cairo' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Cairo</option>
                                <option value="Africa/Ceuta" <?php if( $row->time_zone == 'Africa/Ceuta' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Ceuta</option>
                                <option value="Africa/Gaborone" <?php if( $row->time_zone == 'Africa/Gaborone' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Gaborone</option>
                                <option value="Africa/Harare" <?php if( $row->time_zone == 'Africa/Harare' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Harare</option>
                                <option value="Africa/Johannesburg" <?php if( $row->time_zone == 'Africa/Johannesburg' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Johannesburg</option>
                                <option value="Africa/Khartoum" <?php if( $row->time_zone == 'Africa/Khartoum' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Khartoum</option>
                                <option value="Africa/Kigali" <?php if( $row->time_zone == 'Africa/Kigali' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Kigali</option>
                                <option value="Africa/Lubumbashi" <?php if( $row->time_zone == 'Africa/Lubumbashi' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Lubumbashi</option>
                                <option value="Africa/Lusaka" <?php if( $row->time_zone == 'Africa/Lusaka' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Lusaka</option>
                                <option value="Africa/Maputo" <?php if( $row->time_zone == 'Africa/Maputo' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Maputo</option>
                                <option value="Africa/Maseru" <?php if( $row->time_zone == 'Africa/Maseru' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Maseru</option>
                                <option value="Africa/Mbabane" <?php if( $row->time_zone == 'Africa/Mbabane' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Mbabane</option>
                                <option value="Africa/Tripoli" <?php if( $row->time_zone == 'Africa/Tripoli' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Tripoli</option>
                                <option value="Africa/Windhoek" <?php if( $row->time_zone == 'Africa/Windhoek' ): ?> selected <?php endif; ?>>(GMT+02:00) Africa, Windhoek</option>
                                <option value="Antarctica/Troll" <?php if( $row->time_zone == 'Antarctica/Troll' ): ?> selected <?php endif; ?>>(GMT+02:00) Antarctica, Troll</option>
                                <option value="Arctic/Longyearbyen" <?php if( $row->time_zone == 'Arctic/Longyearbyen' ): ?> selected <?php endif; ?>>(GMT+02:00) Arctic, Longyearbyen</option>
                                <option value="Europe/Amsterdam" <?php if( $row->time_zone == 'Europe/Amsterdam' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Amsterdam</option>
                                <option value="Europe/Andorra" <?php if( $row->time_zone == 'Europe/Andorra' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Andorra</option>
                                <option value="Europe/Belgrade" <?php if( $row->time_zone == 'Europe/Belgrade' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Belgrade</option>
                                <option value="Europe/Berlin" <?php if( $row->time_zone == 'Europe/Berlin' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Berlin</option>
                                <option value="Europe/Bratislava" <?php if( $row->time_zone == 'Europe/Bratislava' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Bratislava</option>
                                <option value="Europe/Brussels" <?php if( $row->time_zone == 'Europe/Brussels' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Brussels</option>
                                <option value="Europe/Budapest" <?php if( $row->time_zone == 'Europe/Budapest' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Budapest</option>
                                <option value="Europe/Busingen" <?php if( $row->time_zone == 'Europe/Busingen' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Busingen</option>
                                <option value="Europe/Copenhagen" <?php if( $row->time_zone == 'Europe/Copenhagen' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Copenhagen</option>
                                <option value="Europe/Gibraltar" <?php if( $row->time_zone == 'Europe/Gibraltar' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Gibraltar</option>
                                <option value="Europe/Kaliningrad" <?php if( $row->time_zone == 'Europe/Kaliningrad' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Kaliningrad</option>
                                <option value="Europe/Ljubljana" <?php if( $row->time_zone == 'Europe/Ljubljana' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Ljubljana</option>
                                <option value="Europe/Luxembourg" <?php if( $row->time_zone == 'Europe/Luxembourg' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Luxembourg</option>
                                <option value="Europe/Madrid" <?php if( $row->time_zone == 'Europe/Madrid' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Madrid</option>
                                <option value="Europe/Malta" <?php if( $row->time_zone == 'Europe/Malta' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Malta</option>
                                <option value="Europe/Monaco" <?php if( $row->time_zone == 'Europe/Monaco' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Monaco</option>
                                <option value="Europe/Oslo" <?php if( $row->time_zone == 'Europe/Oslo' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Oslo</option>
                                <option value="Europe/Paris" <?php if( $row->time_zone == 'Europe/Paris' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Paris</option>
                                <option value="Europe/Podgorica" <?php if( $row->time_zone == 'Europe/Podgorica' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Podgorica</option>
                                <option value="Europe/Prague" <?php if( $row->time_zone == 'Europe/Prague' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Prague</option>
                                <option value="Europe/Rome" <?php if( $row->time_zone == 'Europe/Rome' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Rome</option>
                                <option value="Europe/San_Marino" <?php if( $row->time_zone == 'Europe/San_Marino' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, San Marino</option>
                                <option value="Europe/Sarajevo" <?php if( $row->time_zone == 'Europe/Sarajevo' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Sarajevo</option>
                                <option value="Europe/Skopje" <?php if( $row->time_zone == 'Europe/Skopje' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Skopje</option>
                                <option value="Europe/Stockholm" <?php if( $row->time_zone == 'Europe/Stockholm' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Stockholm</option>
                                <option value="Europe/Tirane" <?php if( $row->time_zone == 'Europe/Tirane' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Tirane</option>
                                <option value="Europe/Vaduz" <?php if( $row->time_zone == 'Europe/Vaduz' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Vaduz</option>
                                <option value="Europe/Vatican" <?php if( $row->time_zone == 'Europe/Vatican' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Vatican</option>
                                <option value="Europe/Vienna" <?php if( $row->time_zone == 'Europe/Vienna' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Vienna</option>
                                <option value="Europe/Warsaw" <?php if( $row->time_zone == 'Europe/Warsaw' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Warsaw</option>
                                <option value="Europe/Zagreb" <?php if( $row->time_zone == 'Europe/Zagreb' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Zagreb</option>
                                <option value="Europe/Zurich" <?php if( $row->time_zone == 'Europe/Zurich' ): ?> selected <?php endif; ?>>(GMT+02:00) Europe, Zurich</option>
                                <option value="Africa/Addis_Ababa" <?php if( $row->time_zone == 'Africa/Addis_Ababa' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Addis Ababa</option>
                                <option value="Africa/Asmara" <?php if( $row->time_zone == 'Africa/Asmara' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Asmara</option>
                                <option value="Africa/Dar_es_Salaam" <?php if( $row->time_zone == 'Africa/Dar_es_Salaam' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Dar es Salaam</option>
                                <option value="Africa/Djibouti" <?php if( $row->time_zone == 'Africa/Djibouti' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Djibouti</option>
                                <option value="Africa/Juba" <?php if( $row->time_zone == 'Africa/Juba' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Juba</option>
                                <option value="Africa/Kampala" <?php if( $row->time_zone == 'Africa/Kampala' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Kampala</option>
                                <option value="Africa/Mogadishu" <?php if( $row->time_zone == 'Africa/Mogadishu' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Mogadishu</option>
                                <option value="Africa/Nairobi" <?php if( $row->time_zone == 'Africa/Nairobi' ): ?> selected <?php endif; ?>>(GMT+03:00) Africa, Nairobi</option>
                                <option value="Antarctica/Syowa" <?php if( $row->time_zone == 'Antarctica/Syowa' ): ?> selected <?php endif; ?>>(GMT+03:00) Antarctica, Syowa</option>
                                <option value="Asia/Aden" <?php if( $row->time_zone == 'Asia/Aden' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Aden</option>
                                <option value="Asia/Amman" <?php if( $row->time_zone == 'Asia/Amman' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Amman</option>
                                <option value="Asia/Baghdad" <?php if( $row->time_zone == 'Asia/Baghdad' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Baghdad</option>
                                <option value="Asia/Bahrain" <?php if( $row->time_zone == 'Asia/Bahrain' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Bahrain</option>
                                <option value="Asia/Beirut" <?php if( $row->time_zone == 'Asia/Beirut' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Beirut</option>
                                <option value="Asia/Damascus" <?php if( $row->time_zone == 'Asia/Damascus' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Damascus</option>
                                <option value="Asia/Famagusta" <?php if( $row->time_zone == 'Asia/Famagusta' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Famagusta</option>
                                <option value="Asia/Gaza" <?php if( $row->time_zone == 'Asia/Gaza' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Gaza</option>
                                <option value="Asia/Hebron" <?php if( $row->time_zone == 'Asia/Hebron' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Hebron</option>
                                <option value="Asia/Jerusalem" <?php if( $row->time_zone == 'Asia/Jerusalem' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Jerusalem</option>
                                <option value="Asia/Kuwait" <?php if( $row->time_zone == 'Asia/Kuwait' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Kuwait</option>
                                <option value="Asia/Nicosia" <?php if( $row->time_zone == 'Asia/Nicosia' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Nicosia</option>
                                <option value="Asia/Qatar" <?php if( $row->time_zone == 'Asia/Qatar' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Qatar</option>
                                <option value="Asia/Riyadh" <?php if( $row->time_zone == 'Asia/Riyadh' ): ?> selected <?php endif; ?>>(GMT+03:00) Asia, Riyadh</option>
                                <option value="Europe/Athens" <?php if( $row->time_zone == 'Europe/Athens' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Athens</option>
                                <option value="Europe/Bucharest" <?php if( $row->time_zone == 'Europe/Bucharest' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Bucharest</option>
                                <option value="Europe/Chisinau" <?php if( $row->time_zone == 'Europe/Chisinau' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Chisinau</option>
                                <option value="Europe/Helsinki" <?php if( $row->time_zone == 'Europe/Helsinki' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Helsinki</option>
                                <option value="Europe/Istanbul" <?php if( $row->time_zone == 'Europe/Istanbul' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Istanbul</option>
                                <option value="Europe/Kiev" <?php if( $row->time_zone == 'Europe/Kiev' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Kiev</option>
                                <option value="Europe/Kirov" <?php if( $row->time_zone == 'Europe/Kirov' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Kirov</option>
                                <option value="Europe/Mariehamn" <?php if( $row->time_zone == 'Europe/Mariehamn' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Mariehamn</option>
                                <option value="Europe/Minsk" <?php if( $row->time_zone == 'Europe/Minsk' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Minsk</option>
                                <option value="Europe/Moscow" <?php if( $row->time_zone == 'Europe/Moscow' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Moscow</option>
                                <option value="Europe/Riga" <?php if( $row->time_zone == 'Europe/Riga' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Riga</option>
                                <option value="Europe/Simferopol" <?php if( $row->time_zone == 'Europe/Simferopol' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Simferopol</option>
                                <option value="Europe/Sofia" <?php if( $row->time_zone == 'Europe/Sofia' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Sofia</option>
                                <option value="Europe/Tallinn" <?php if( $row->time_zone == 'Europe/Tallinn' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Tallinn</option>
                                <option value="Europe/Uzhgorod" <?php if( $row->time_zone == 'Europe/Uzhgorod' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Uzhgorod</option>
                                <option value="Europe/Vilnius" <?php if( $row->time_zone == 'Europe/Vilnius' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Vilnius</option>
                                <option value="Europe/Zaporozhye" <?php if( $row->time_zone == 'Europe/Zaporozhye' ): ?> selected <?php endif; ?>>(GMT+03:00) Europe, Zaporozhye</option>
                                <option value="Indian/Antananarivo" <?php if( $row->time_zone == 'Indian/Antananarivo' ): ?> selected <?php endif; ?>>(GMT+03:00) Indian, Antananarivo</option>
                                <option value="Indian/Comoro" <?php if( $row->time_zone == 'Indian/Comoro' ): ?> selected <?php endif; ?>>(GMT+03:00) Indian, Comoro</option>
                                <option value="Indian/Mayotte" <?php if( $row->time_zone == 'Indian/Mayotte' ): ?> selected <?php endif; ?>>(GMT+03:00) Indian, Mayotte</option>
                                <option value="Asia/Baku" <?php if( $row->time_zone == 'Asia/Baku' ): ?> selected <?php endif; ?>>(GMT+04:00) Asia, Baku</option>
                                <option value="Asia/Dubai" <?php if( $row->time_zone == 'Asia/Dubai' ): ?> selected <?php endif; ?>>(GMT+04:00) Asia, Dubai</option>
                                <option value="Asia/Muscat" <?php if( $row->time_zone == 'Asia/Muscat' ): ?> selected <?php endif; ?>>(GMT+04:00) Asia, Muscat</option>
                                <option value="Asia/Tbilisi" <?php if( $row->time_zone == 'Asia/Tbilisi' ): ?> selected <?php endif; ?>>(GMT+04:00) Asia, Tbilisi</option>
                                <option value="Asia/Yerevan" <?php if( $row->time_zone == 'Asia/Yerevan' ): ?> selected <?php endif; ?>>(GMT+04:00) Asia, Yerevan</option>
                                <option value="Europe/Astrakhan" <?php if( $row->time_zone == 'Europe/Astrakhan' ): ?> selected <?php endif; ?>>(GMT+04:00) Europe, Astrakhan</option>
                                <option value="Europe/Samara" <?php if( $row->time_zone == 'Europe/Samara' ): ?> selected <?php endif; ?>>(GMT+04:00) Europe, Samara</option>
                                <option value="Europe/Saratov" <?php if( $row->time_zone == 'Europe/Saratov' ): ?> selected <?php endif; ?>>(GMT+04:00) Europe, Saratov</option>
                                <option value="Europe/Ulyanovsk" <?php if( $row->time_zone == 'Europe/Ulyanovsk' ): ?> selected <?php endif; ?>>(GMT+04:00) Europe, Ulyanovsk</option>
                                <option value="Europe/Volgograd" <?php if( $row->time_zone == 'Europe/Volgograd' ): ?> selected <?php endif; ?>>(GMT+04:00) Europe, Volgograd</option>
                                <option value="Indian/Mahe" <?php if( $row->time_zone == 'Indian/Mahe' ): ?> selected <?php endif; ?>>(GMT+04:00) Indian, Mahe</option>
                                <option value="Indian/Mauritius" <?php if( $row->time_zone == 'Indian/Mauritius' ): ?> selected <?php endif; ?>>(GMT+04:00) Indian, Mauritius</option>
                                <option value="Indian/Reunion" <?php if( $row->time_zone == 'Indian/Reunion' ): ?> selected <?php endif; ?>>(GMT+04:00) Indian, Reunion</option>
                                <option value="Asia/Kabul" <?php if( $row->time_zone == 'Asia/Kabul' ): ?> selected <?php endif; ?>>(GMT+04:30) Asia, Kabul</option>
                                <option value="Asia/Tehran" <?php if( $row->time_zone == 'Asia/Tehran' ): ?> selected <?php endif; ?>>(GMT+04:30) Asia, Tehran</option>
                                <option value="Antarctica/Mawson" <?php if( $row->time_zone == 'Antarctica/Mawson' ): ?> selected <?php endif; ?>>(GMT+05:00) Antarctica, Mawson</option>
                                <option value="Asia/Aqtau" <?php if( $row->time_zone == 'Asia/Aqtau' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Aqtau</option>
                                <option value="Asia/Aqtobe" <?php if( $row->time_zone == 'Asia/Aqtobe' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Aqtobe</option>
                                <option value="Asia/Ashgabat" <?php if( $row->time_zone == 'Asia/Ashgabat' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Ashgabat</option>
                                <option value="Asia/Atyrau" <?php if( $row->time_zone == 'Asia/Atyrau' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Atyrau</option>
                                <option value="Asia/Dushanbe" <?php if( $row->time_zone == 'Asia/Dushanbe' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Dushanbe</option>
                                <option value="Asia/Karachi" <?php if( $row->time_zone == 'Asia/Karachi' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Karachi</option>
                                <option value="Asia/Oral" <?php if( $row->time_zone == 'Asia/Oral' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Oral</option>
                                <option value="Asia/Qyzylorda" <?php if( $row->time_zone == 'Asia/Qyzylorda' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Qyzylorda</option>
                                <option value="Asia/Samarkand" <?php if( $row->time_zone == 'Asia/Samarkand' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Samarkand</option>
                                <option value="Asia/Tashkent" <?php if( $row->time_zone == 'Asia/Tashkent' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Tashkent</option>
                                <option value="Asia/Yekaterinburg" <?php if( $row->time_zone == 'Asia/Yekaterinburg' ): ?> selected <?php endif; ?>>(GMT+05:00) Asia, Yekaterinburg</option>
                                <option value="Indian/Kerguelen" <?php if( $row->time_zone == 'Indian/Kerguelen' ): ?> selected <?php endif; ?>>(GMT+05:00) Indian, Kerguelen</option>
                                <option value="Indian/Maldives" <?php if( $row->time_zone == 'Indian/Maldives' ): ?> selected <?php endif; ?>>(GMT+05:00) Indian, Maldives</option>
                                <option value="Asia/Colombo" <?php if( $row->time_zone == 'Asia/Colombo' ): ?> selected <?php endif; ?>>(GMT+05:30) Asia, Colombo</option>
                                <option value="Asia/Kolkata" <?php if( $row->time_zone == 'Asia/Kolkata' ): ?> selected <?php endif; ?>>(GMT+05:30) Asia, Kolkata</option>
                                <option value="Asia/Kathmandu" <?php if( $row->time_zone == 'Asia/Kathmandu' ): ?> selected <?php endif; ?>>(GMT+05:45) Asia, Kathmandu</option>
                                <option value="Antarctica/Vostok" <?php if( $row->time_zone == 'Antarctica/Vostok' ): ?> selected <?php endif; ?>>(GMT+06:00) Antarctica, Vostok</option>
                                <option value="Asia/Almaty" <?php if( $row->time_zone == 'Asia/Almaty' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Almaty</option>
                                <option value="Asia/Bishkek" <?php if( $row->time_zone == 'Asia/Bishkek' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Bishkek</option>
                                <option value="Asia/Dhaka" <?php if( $row->time_zone == 'Asia/Dhaka' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Dhaka</option>
                                <option value="Asia/Omsk" <?php if( $row->time_zone == 'Asia/Omsk' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Omsk</option>
                                <option value="Asia/Qostanay" <?php if( $row->time_zone == 'Asia/Qostanay' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Qostanay</option>
                                <option value="Asia/Thimphu" <?php if( $row->time_zone == 'Asia/Thimphu' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Thimphu</option>
                                <option value="Asia/Urumqi" <?php if( $row->time_zone == 'Asia/Urumqi' ): ?> selected <?php endif; ?>>(GMT+06:00) Asia, Urumqi</option>
                                <option value="Indian/Chagos" <?php if( $row->time_zone == 'Indian/Chagos' ): ?> selected <?php endif; ?>>(GMT+06:00) Indian, Chagos</option>
                                <option value="Asia/Yangon" <?php if( $row->time_zone == 'Asia/Yangon' ): ?> selected <?php endif; ?>>(GMT+06:30) Asia, Yangon</option>
                                <option value="Indian/Cocos" <?php if( $row->time_zone == 'Indian/Cocos' ): ?> selected <?php endif; ?>>(GMT+06:30) Indian, Cocos</option>
                                <option value="Antarctica/Davis" <?php if( $row->time_zone == 'Antarctica/Davis' ): ?> selected <?php endif; ?>>(GMT+07:00) Antarctica, Davis</option>
                                <option value="Asia/Bangkok" <?php if( $row->time_zone == 'Asia/Bangkok' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Bangkok</option>
                                <option value="Asia/Barnaul" <?php if( $row->time_zone == 'Asia/Barnaul' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Barnaul</option>
                                <option value="Asia/Ho_Chi_Minh" <?php if( $row->time_zone == 'Asia/Ho_Chi_Minh' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Ho Chi Minh</option>
                                <option value="Asia/Hovd" <?php if( $row->time_zone == 'Asia/Hovd' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Hovd</option>
                                <option value="Asia/Jakarta" <?php if( $row->time_zone == 'Asia/Jakarta' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Jakarta</option>
                                <option value="Asia/Krasnoyarsk" <?php if( $row->time_zone == 'Asia/Krasnoyarsk' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Krasnoyarsk</option>
                                <option value="Asia/Novokuznetsk" <?php if( $row->time_zone == 'Asia/Novokuznetsk' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Novokuznetsk</option>
                                <option value="Asia/Novosibirsk" <?php if( $row->time_zone == 'Asia/Novosibirsk' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Novosibirsk</option>
                                <option value="Asia/Phnom_Penh" <?php if( $row->time_zone == 'Asia/Phnom_Penh' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Phnom Penh</option>
                                <option value="Asia/Pontianak" <?php if( $row->time_zone == 'Asia/Pontianak' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Pontianak</option>
                                <option value="Asia/Tomsk" <?php if( $row->time_zone == 'Asia/Tomsk' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Tomsk</option>
                                <option value="Asia/Vientiane" <?php if( $row->time_zone == 'Asia/Vientiane' ): ?> selected <?php endif; ?>>(GMT+07:00) Asia, Vientiane</option>
                                <option value="Indian/Christmas" <?php if( $row->time_zone == 'Indian/Christmas' ): ?> selected <?php endif; ?>>(GMT+07:00) Indian, Christmas</option>
                                <option value="Antarctica/Casey" <?php if( $row->time_zone == 'Antarctica/Casey' ): ?> selected <?php endif; ?>>(GMT+08:00) Antarctica, Casey</option>
                                <option value="Asia/Brunei" <?php if( $row->time_zone == 'Asia/Brunei' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Brunei</option>
                                <option value="Asia/Choibalsan" <?php if( $row->time_zone == 'Asia/Choibalsan' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Choibalsan</option>
                                <option value="Asia/Hong_Kong" <?php if( $row->time_zone == 'Asia/Hong_Kong' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Hong Kong</option>
                                <option value="Asia/Irkutsk" <?php if( $row->time_zone == 'Asia/Irkutsk' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Irkutsk</option>
                                <option value="Asia/Kuala_Lumpur" <?php if( $row->time_zone == 'Asia/Kuala_Lumpur' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Kuala Lumpur</option>
                                <option value="Asia/Kuching" <?php if( $row->time_zone == 'Asia/Kuching' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Kuching</option>
                                <option value="Asia/Macau" <?php if( $row->time_zone == 'Asia/Macau' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Macau</option>
                                <option value="Asia/Makassar" <?php if( $row->time_zone == 'Asia/Makassar' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Makassar</option>
                                <option value="Asia/Manila" <?php if( $row->time_zone == 'Asia/Manila' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Manila</option>
                                <option value="Asia/Shanghai" <?php if( $row->time_zone == 'Asia/Shanghai' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Shanghai</option>
                                <option value="Asia/Singapore" <?php if( $row->time_zone == 'Asia/Singapore' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Singapore</option>
                                <option value="Asia/Taipei" <?php if( $row->time_zone == 'Asia/Taipei' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Taipei</option>
                                <option value="Asia/Ulaanbaatar" <?php if( $row->time_zone == 'Asia/Ulaanbaatar' ): ?> selected <?php endif; ?>>(GMT+08:00) Asia, Ulaanbaatar</option>
                                <option value="Australia/Perth" <?php if( $row->time_zone == 'Australia/Perth' ): ?> selected <?php endif; ?>>(GMT+08:00) Australia, Perth</option>
                                <option value="Australia/Eucla" <?php if( $row->time_zone == 'Australia/Eucla' ): ?> selected <?php endif; ?>>(GMT+08:45) Australia, Eucla</option>
                                <option value="Asia/Chita" <?php if( $row->time_zone == 'Asia/Chita' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Chita</option>
                                <option value="Asia/Dili" <?php if( $row->time_zone == 'Asia/Dili' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Dili</option>
                                <option value="Asia/Jayapura" <?php if( $row->time_zone == 'Asia/Jayapura' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Jayapura</option>
                                <option value="Asia/Khandyga" <?php if( $row->time_zone == 'Asia/Khandyga' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Khandyga</option>
                                <option value="Asia/Pyongyang" <?php if( $row->time_zone == 'Asia/Pyongyang' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Pyongyang</option>
                                <option value="Asia/Seoul" <?php if( $row->time_zone == 'Asia/Seoul' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Seoul</option>
                                <option value="Asia/Tokyo" <?php if( $row->time_zone == 'Asia/Tokyo' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Tokyo</option>
                                <option value="Asia/Yakutsk" <?php if( $row->time_zone == 'Asia/Yakutsk' ): ?> selected <?php endif; ?>>(GMT+09:00) Asia, Yakutsk</option>
                                <option value="Pacific/Palau" <?php if( $row->time_zone == 'Pacific/Palau' ): ?> selected <?php endif; ?>>(GMT+09:00) Pacific, Palau</option>
                                <option value="Australia/Adelaide" <?php if( $row->time_zone == 'Australia/Adelaide' ): ?> selected <?php endif; ?>>(GMT+09:30) Australia, Adelaide</option>
                                <option value="Australia/Broken_Hill" <?php if( $row->time_zone == 'Australia/Broken_Hill' ): ?> selected <?php endif; ?>>(GMT+09:30) Australia, Broken Hill</option>
                                <option value="Australia/Darwin" <?php if( $row->time_zone == 'Australia/Darwin' ): ?> selected <?php endif; ?>>(GMT+09:30) Australia, Darwin</option>
                                <option value="Antarctica/DumontDUrville" <?php if( $row->time_zone == 'Antarctica/DumontDUrville' ): ?> selected <?php endif; ?>>(GMT+10:00) Antarctica, DumontDUrville</option>
                                <option value="Asia/Ust-Nera" <?php if( $row->time_zone == 'Asia/Ust-Nera' ): ?> selected <?php endif; ?>>(GMT+10:00) Asia, Ust-Nera</option>
                                <option value="Asia/Vladivostok" <?php if( $row->time_zone == 'Asia/Vladivostok' ): ?> selected <?php endif; ?>>(GMT+10:00) Asia, Vladivostok</option>
                                <option value="Australia/Brisbane" <?php if( $row->time_zone == 'Australia/Brisbane' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Brisbane</option>
                                <option value="Australia/Currie" <?php if( $row->time_zone == 'Australia/Currie' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Currie</option>
                                <option value="Australia/Hobart" <?php if( $row->time_zone == 'Australia/Hobart' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Hobart</option>
                                <option value="Australia/Lindeman" <?php if( $row->time_zone == 'Australia/Lindeman' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Lindeman</option>
                                <option value="Australia/Melbourne" <?php if( $row->time_zone == 'Australia/Melbourne' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Melbourne</option>
                                <option value="Australia/Sydney" <?php if( $row->time_zone == 'Australia/Sydney' ): ?> selected <?php endif; ?>>(GMT+10:00) Australia, Sydney</option>
                                <option value="Pacific/Chuuk" <?php if( $row->time_zone == 'Pacific/Chuuk' ): ?> selected <?php endif; ?>>(GMT+10:00) Pacific, Chuuk</option>
                                <option value="Pacific/Guam" <?php if( $row->time_zone == 'Pacific/Guam' ): ?> selected <?php endif; ?>>(GMT+10:00) Pacific, Guam</option>
                                <option value="Pacific/Port_Moresby" <?php if( $row->time_zone == 'Pacific/Port_Moresby' ): ?> selected <?php endif; ?>>(GMT+10:00) Pacific, Port Moresby</option>
                                <option value="Pacific/Saipan" <?php if( $row->time_zone == 'Pacific/Saipan' ): ?> selected <?php endif; ?>>(GMT+10:00) Pacific, Saipan</option>
                                <option value="Australia/Lord_Howe" <?php if( $row->time_zone == 'Australia/Lord_Howe' ): ?> selected <?php endif; ?>>(GMT+10:30) Australia, Lord Howe</option>
                                <option value="Antarctica/Macquarie" <?php if( $row->time_zone == 'Antarctica/Macquarie' ): ?> selected <?php endif; ?>>(GMT+11:00) Antarctica, Macquarie</option>
                                <option value="Asia/Magadan" <?php if( $row->time_zone == 'Asia/Magadan' ): ?> selected <?php endif; ?>>(GMT+11:00) Asia, Magadan</option>
                                <option value="Asia/Sakhalin" <?php if( $row->time_zone == 'Asia/Sakhalin' ): ?> selected <?php endif; ?>>(GMT+11:00) Asia, Sakhalin</option>
                                <option value="Asia/Srednekolymsk" <?php if( $row->time_zone == 'Asia/Srednekolymsk' ): ?> selected <?php endif; ?>>(GMT+11:00) Asia, Srednekolymsk</option>
                                <option value="Pacific/Bougainville" <?php if( $row->time_zone == 'Pacific/Bougainville' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Bougainville</option>
                                <option value="Pacific/Efate" <?php if( $row->time_zone == 'Pacific/Efate' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Efate</option>
                                <option value="Pacific/Guadalcanal" <?php if( $row->time_zone == 'Pacific/Guadalcanal' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Guadalcanal</option>
                                <option value="Pacific/Kosrae" <?php if( $row->time_zone == 'Pacific/Kosrae' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Kosrae</option>
                                <option value="Pacific/Norfolk" <?php if( $row->time_zone == 'Pacific/Norfolk' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Norfolk</option>
                                <option value="Pacific/Noumea" <?php if( $row->time_zone == 'Pacific/Noumea' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Noumea</option>
                                <option value="Pacific/Pohnpei" <?php if( $row->time_zone == 'Pacific/Pohnpei' ): ?> selected <?php endif; ?>>(GMT+11:00) Pacific, Pohnpei</option>
                                <option value="Antarctica/McMurdo" <?php if( $row->time_zone == 'Antarctica/McMurdo' ): ?> selected <?php endif; ?>>(GMT+12:00) Antarctica, McMurdo</option>
                                <option value="Asia/Anadyr" <?php if( $row->time_zone == 'Asia/Anadyr' ): ?> selected <?php endif; ?>>(GMT+12:00) Asia, Anadyr</option>
                                <option value="Asia/Kamchatka" <?php if( $row->time_zone == 'Asia/Kamchatka' ): ?> selected <?php endif; ?>>(GMT+12:00) Asia, Kamchatka</option>
                                <option value="Pacific/Auckland" <?php if( $row->time_zone == 'Pacific/Auckland' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Auckland</option>
                                <option value="Pacific/Fiji" <?php if( $row->time_zone == 'Pacific/Fiji' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Fiji</option>
                                <option value="Pacific/Funafuti" <?php if( $row->time_zone == 'Pacific/Funafuti' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Funafuti</option>
                                <option value="Pacific/Kwajalein" <?php if( $row->time_zone == 'Pacific/Kwajalein' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Kwajalein</option>
                                <option value="Pacific/Majuro" <?php if( $row->time_zone == 'Pacific/Majuro' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Majuro</option>
                                <option value="Pacific/Nauru" <?php if( $row->time_zone == 'Pacific/Nauru' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Nauru</option>
                                <option value="Pacific/Tarawa" <?php if( $row->time_zone == 'Pacific/Tarawa' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Tarawa</option>
                                <option value="Pacific/Wake" <?php if( $row->time_zone == 'Pacific/Wake' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Wake</option>
                                <option value="Pacific/Wallis" <?php if( $row->time_zone == 'Pacific/Wallis' ): ?> selected <?php endif; ?>>(GMT+12:00) Pacific, Wallis</option>
                                <option value="Pacific/Chatham" <?php if( $row->time_zone == 'Pacific/Chatham' ): ?> selected <?php endif; ?>>(GMT+12:45) Pacific, Chatham</option>
                                <option value="Pacific/Apia" <?php if( $row->time_zone == 'Pacific/Apia' ): ?> selected <?php endif; ?>>(GMT+13:00) Pacific, Apia</option>
                                <option value="Pacific/Enderbury" <?php if( $row->time_zone == 'Pacific/Enderbury' ): ?> selected <?php endif; ?>>(GMT+13:00) Pacific, Enderbury</option>
                                <option value="Pacific/Fakaofo" <?php if( $row->time_zone == 'Pacific/Fakaofo' ): ?> selected <?php endif; ?>>(GMT+13:00) Pacific, Fakaofo</option>
                                <option value="Pacific/Tongatapu" <?php if( $row->time_zone == 'Pacific/Tongatapu' ): ?> selected <?php endif; ?>>(GMT+13:00) Pacific, Tongatapu</option>
                                <option value="Pacific/Kiritimati" <?php if( $row->time_zone == 'Pacific/Kiritimati' ): ?> selected <?php endif; ?>>(GMT+14:00) Pacific, Kiritimati</option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_time_zone')); ?>

                            </div>
                        </div>
                        <?php endif; ?>

                        <hr/>

                        <div class="form-group col-md-4">
                            <label for="currency"><?php echo e(__('field_currency')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="currency" id="currency" value="<?php echo e(isset($row->currency)?$row->currency:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_currency')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="currency_symbol"><?php echo e(__('field_currency_symbol')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="currency_symbol" id="currency_symbol" value="<?php echo e(isset($row->currency_symbol)?$row->currency_symbol:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_currency_symbol')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="decimal_place"><?php echo e(__('field_decimal_place')); ?> <span>*</span></label>
                            <select class="form-control" name="decimal_place" id="decimal_place" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="0" <?php if( $row->decimal_place == '0' ): ?> selected <?php endif; ?>>Zero / Null</option>
                                <option value="2" <?php if( $row->decimal_place == '2' ): ?> selected <?php endif; ?>>2 Decimal Point</option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_decimal_place')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="copyright_text"><?php echo e(__('field_copyright_text')); ?></label>
                            <textarea class="form-control texteditor" name="copyright_text" id="copyright_text"><?php echo e(isset($row->copyright_text)?$row->copyright_text:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_copyright_text')); ?>

                            </div>
                        </div>
                        <!-- Form End -->

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                    </div>

                </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/setting/index.blade.php ENDPATH**/ ?>