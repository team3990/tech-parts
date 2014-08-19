@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Pièces
        @stop
        
        @section('stylesheets')
            @parent
            <!-- Selectize.js -->
        	{{ HTML::style('/assets/selectize/dist/css/selectize.bootstrap3.css'); }}
        	<!-- Bootstrap Datetime Picker -->
            {{ HTML::style('/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); }}
        @stop
        
        @section('scripts_header')
            @parent
            <!-- Selectize.js -->
        	{{ HTML::script('/assets/selectize/dist/js/standalone/selectize.min.js'); }}
        	<!-- Bootstrap Datetime Picker -->
            {{ HTML::script('/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'); }}
            {{ HTML::script('/assets/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js'); }}
        @stop
        
    @stop

    {{-- HTML Body Section --}}
    @section('body')
    
        @parent
    
        @section('content')
        	
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1><i class="fa fa-cog fa-fw"></i> Pièces <small><?php echo ($currentRoute == 'parts.pieces.create') ? 'Ajouter' : 'Modifier'; ?> une pièce (<?php echo str_pad($piece_type->id, 2, '0', STR_PAD_LEFT); ?>) <?php echo $piece_type->title; ?></small></h1>
                    </div>
                </div>
            </div>
            
                <?php if ($errors->count() > 0) : ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-circle fa-fw fa-3x pull-left"></i>
                        <div style="margin-left: 70px">
                            <h4>Oups!</h4> La pièce n'a pu être <?php echo ($currentRoute == 'parts.pieces.create') ? 'ajoutée' : 'modifiée'; ?>. Les erreurs suivants se sont produits:
                            <?php echo HTML::ul($errors->all()); ?>
                        </div>
                    </div>
                <?php endif; ?>
            
                <?php echo ($currentRoute == 'parts.pieces.create') ? Form::open(array('route' => array('parts.pieces.store', $subassembly->id, $piece_type->id), 'files' => true)) : Form::model($piece, array('route' => array('parts.pieces.update', $piece->id), 'files' => true)); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning" ><i class="fa fa-save fa-fw"></i> <?php echo ($currentRoute == 'parts.pieces.create') ? 'Ajouter la pièce' : 'Enregistrer les modifications'; ?></button>
                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo ($currentRoute == 'parts.pieces.create') ? route('parts.subassemblies.view', $subassembly->id) : route('parts.pieces.view', $piece->id); ?>" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Annuler</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="col-sm-6 col-xs-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#form-info" role="tab" data-toggle="tab"><i class="fa fa-folder-open-o fa-fw"></i> Informations</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="form-info">
                                    <div class="panel panel-default panel-tabs">
                                        <div class="panel-body">
                                            <dl>
                                            	
                                                <dt><label for="title">Nom de la pièce</label></dt>
                                                <dd><?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Nom de la pièce...', 'id' => 'title')); ?></dd>
                                                
                                                <dt><label for="code">Code de la pièce</label></dt>
                                                <dd>
                                                	<div class="input-group col-xs-3">
                                                		<span class="input-group-addon">CRA-<?php echo $assembly->code.$subassembly->code; ?></span>
                                                		<?php echo Form::text('code', null, array('class' => 'form-control text-center', 'placeholder' => '00', 'id' => 'code', 'maxlength' => '2')); ?>
                                                	</div>
                                                </dd>
                                                
                                                <dt><label>Type de la pièce</label></dt>
                                                <dd>
                                                	<?php echo Form::hidden('piece_type_id', $piece_type->id); ?>
                                                	<span class="label label-default"><?php echo str_pad($piece_type->id, 2, '0', STR_PAD_LEFT); ?></span> <?php echo $piece_type->title; ?>
                                                </dd>
                                                
                                                <?php if (in_array($piece_type->id, array(1, 2))) : ?>
                                                <dt><label for="author_id">Auteur de la pièce</label></dt>
                                                <dd>
                                                	<?php $users_array = array('Élèves' => array(), 'Mentors et apprentis mentors' => array()); 
                                                	foreach ($users as $user) 
													{
														if ($user->is_mentor || $user->is_junior_mentor) 	$users_array['Mentors et apprentis mentors'][$user->id] = $user->full_name;
														if ($user->is_student) 								$users_array['Élèves'][$user->id] = $user->full_name;
													}
													?>
                                                	<?php echo Form::select('author_id', $users_array, Auth::user()->id, array('class' => 'form-control', 'id' => 'author_id')); ?>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="desc">Description</label></dt>
                                                <dd><?php echo Form::textarea('desc', null, array('class' => 'form-control', 'placeholder' => 'Description de la pièce...', 'id' => 'desc')); ?></dd>
                                                
                                                <dt><label>Dans le sous-assemblage</label></dt>
                                                <dd>
                                                	<?php echo Form::hidden('subassembly_id', $subassembly->id); ?>
                                                	<span class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $project->title; ?></span> 
                                                	<i class="fa fa-angle-right fa-fw"></i> 
                                                	<span class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></span> 
                                                	<i class="fa fa-angle-right fa-fw"></i> 
                                                	<span class="bg-info"><i class="fa fa-cube fa-fw"></i> <?php echo $subassembly->title; ?></span> 
                                                </dd>
                                                
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-xs-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#form-info" role="tab" data-toggle="tab"><i class="fa fa-cog fa-fw"></i> <span class="label label-default"><?php echo str_pad($piece_type->id, 2, '0', STR_PAD_LEFT); ?></span> <?php echo $piece_type->title; ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="form-info">
                                    <div class="panel panel-default panel-tabs">
                                        <div class="panel-body">
                                            <dl>
                                                
                                                <?php if (in_array($piece_type->id, array(2, 3))) : ?>
                                                <dt><label for="provider_id">Fournisseur</label></dt>
                                                <dd>
                                                	<?php $providers_array = array(); 
                                                	foreach ($providers as $provider) 
													{
														$providers_array[$provider->id] = $provider->title;
													}
													?>
                                                	<?php echo Form::select('provider_id', $providers_array, null, array('class' => 'form-control', 'id' => 'provider_id')); ?>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <dt>
                                                	<label for="datetime_due">Date due</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date limite avant laquelle la pièce doit être terminée."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_due', null, array('class' => 'form-control date', 'placeholder' => 'Date due...', 'id' => 'datetime_due')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                
                                                <?php if (in_array($piece_type->id, array(2))) : ?>
                                                <dt>
                                                	<label for="datetime_tosend">Date à envoyer au fournisseur</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date limite avant laquelle la pièce doit être envoyée au fournisseur."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_tosend', null, array('class' => 'form-control date', 'placeholder' => 'Date à envoyer au fournisseur...', 'id' => 'datetime_tosend')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                
                                                <dt>
                                                	<label for="datetime_sent">Date envoyée au fournisseur</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date à laquelle la pièce a été envoyée au fournisseur pour production."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_sent', null, array('class' => 'form-control date', 'placeholder' => 'Date envoyée au fournisseur...', 'id' => 'datetime_sent')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece_type->id, array(2, 3))) : ?>
                                                <dt>
                                                	<label for="datetime_toreceive">Date à recevoir du fournisseur</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date à laquelle le fournisseur s'est engagé à envoyer la pièce"></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_toreceive', null, array('class' => 'form-control date', 'placeholder' => 'Date à recevoir du fournisseur...', 'id' => 'datetime_toreceive')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                
                                                <dt>
                                                	<label for="datetime_received">Date reçue du fournisseur</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date à laquelle la pièce a été reçue du fournisseur."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_received', null, array('class' => 'form-control date', 'placeholder' => 'Date reçue du fournisseur...', 'id' => 'datetime_received')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece_type->id, array(3))) : ?>
                                                <dt>
                                                	<label for="datetime_toorder">Date à commander</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date limite avant laquelle la pièce doit être commandée du fournisseur."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_toorder', null, array('class' => 'form-control date', 'placeholder' => 'Date à commander...', 'id' => 'datetime_toorder')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                
                                                <dt>
                                                	<label for="datetime_ordered">Date commandée</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Date à laquelle la pièce a été commandée du fournisseur."></i>
                                                </dt>
                                                <dd>
                                                    <div class="input-group">
                                                        <?php echo Form::text('datetime_ordered', null, array('class' => 'form-control date', 'placeholder' => 'Date commandée...', 'id' => 'datetime_ordered')); ?>
                                                        <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
                                                    </div>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece_type->id, array(1))) : ?>
                                                <dt><label for="material">Matériel</label></dt>
                                                <dd><?php echo Form::text('material', null, array('class' => 'form-control', 'placeholder' => 'Matériel utilisé pour la pièce...', 'id' => 'material')); ?></dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece_type->id, array(2, 3))) : ?>
                                                <dt><label for="unit_price">Prix unitaire</label></dt>
                                                <dd>
                                                	<div class="input-group">
                                                		<?php echo Form::text('unit_price', null, array('class' => 'form-control text-right', 'placeholder' => '00,00', 'id' => 'unit_price')); ?>
                                                		<span class="input-group-addon">$</span>
                                                	</div>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="material">Quantité</label></dt>
                                                <dd><?php echo Form::text('quantity', null, array('class' => 'form-control text-right', 'placeholder' => '0', 'id' => 'quantity')); ?></dd>
                                                
                                                <?php if (in_array($piece_type->id, array(2, 3))) : ?>
                                                <dt><label for="invoice">Facture</label></dt>
                                                <dd>
                                                	<?php echo (empty($piece->invoice)) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->invoice_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->invoice.'</a>'; ?>
		                                        	<?php echo (empty($piece->invoice)) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->invoice_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
		                                        	<div class="small text-muted" style="margin-top: 10px"><?php echo (empty($piece->invoice)) ? 'Sélectionnez un fichier PDF:' : 'Sélectionnez un autre fichier pour remplacer le fichier existant:'; ?></div>
                                                	<?php echo Form::file('invoice', array('id' => 'invoice')); ?>
                                                </dd>
                                                <?php endif; ?>

                                                <?php if (in_array($piece_type->id, array(2))) : ?>
                                                <dt><label for="quote">Soumission du fournisseur</label></dt>
                                                <dd>
                                                	<?php echo (empty($piece->quote)) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->quote_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->quote.'</a>'; ?>
		                                        	<?php echo (empty($piece->quote)) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->quote_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
		                                        	<div class="small text-muted" style="margin-top: 10px"><?php echo (empty($piece->quote)) ? 'Sélectionnez un fichier PDF:' : 'Sélectionnez un autre fichier pour remplacer le fichier existant:'; ?></div>
                                                	<?php echo Form::file('quote', array('id' => 'quote')); ?>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <dt>
                                                	<label for="technical_drawing">Dessin technique</label>
                                                	<i class="fa fa-info-circle fa-fw toggle-tooltip text-info pull-right" data-toggle="tooltip" data-placement="right" title="Dessin technique de la pièce en format PDF."></i>
                                                </dt>
                                                <dd>
                                                	<?php echo (empty($piece->technical_drawing)) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->technical_drawing_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->technical_drawing.'</a>'; ?>
                                                	<?php echo (empty($piece->technical_drawing)) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->technical_drawing_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
		                                        	<div class="small text-muted" style="margin-top: 10px"><?php echo (empty($piece->technical_drawing)) ? 'Sélectionnez un fichier PDF:' : 'Sélectionnez un autre fichier pour remplacer le fichier existant:'; ?></div>
                                                	<?php echo Form::file('technical_drawing', array('id' => 'technical_drawing')); ?>
                                                </dd>
                                                
                                                <?php if (in_array($piece_type->id, array(3))) : ?>
                                                <dt><label for="external_link">Lien Web de la pièce</label></dt>
                                                <dd><?php echo Form::text('external_link', null, array('class' => 'form-control', 'placeholder' => 'Lien Web de la pièce...', 'id' => 'external_link')); ?></dd>
                                                <?php endif; ?>

                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                <?php echo Form::close(); ?>
                                
        @stop
        
    @stop
    
    @section('footer')
        
        @parent 
        
        @section('footer-content')
            @parent
        @stop
    
        @section('scripts_eof')
            @parent
            <script type="text/javascript">
            	$('.toggle-tooltip').tooltip({container: 'body'});
            </script>
                
            <script type="text/javascript">
            
            $(function() {
                $('#author_id').selectize({
                    create: false,
                    valueField: 'id',
                    labelField: 'full_name',
                    searchField: 'full_name'
                });
            });

            $(function() {
                $('#provider_id').selectize({
                    create: true,
                    valueField: 'id',
                });
            });
            
            </script>
            
            <script type="text/javascript">
                // Datetime Picker
                var datetimepickerParam1 = {
                        language: 'fr',
                        autoclose: true,
                        format: 'yyyy-mm-dd',
                        startView: 3,
                        minView: 2,
                        maxView: 3,
                        minuteStep: 15,
                        todayBtn: true,
                        todayHighlight: true
                };

                $('#datetime_due').datetimepicker(datetimepickerParam1);
                $('#datetime_tosend').datetimepicker(datetimepickerParam1);
                $('#datetime_sent').datetimepicker(datetimepickerParam1);
                $('#datetime_toreceive').datetimepicker(datetimepickerParam1);
                $('#datetime_received').datetimepicker(datetimepickerParam1);
                $('#datetime_toorder').datetimepicker(datetimepickerParam1);
                $('#datetime_ordered').datetimepicker(datetimepickerParam1);
                
            </script>
        @stop
        
    @stop
