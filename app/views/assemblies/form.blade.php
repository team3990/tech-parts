@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Assemblages
        @stop
        
        @section('stylesheets')
            @parent
            <!-- Selectize.js -->
        	{{ HTML::style('/assets/selectize/dist/css/selectize.bootstrap3.css'); }}
        @stop
        
        @section('scripts_header')
            @parent
            <!-- Selectize.js -->
        	{{ HTML::script('/assets/selectize/dist/js/standalone/selectize.min.js'); }}
        @stop
        
    @stop

    {{-- HTML Body Section --}}
    @section('body')
    
        @parent
    
        @section('content')
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1><i class="fa fa-cubes fa-fw"></i> Assemblages <small><?php echo ($currentRoute == 'parts.assemblies.create') ? 'Ajouter' : 'Modifier'; ?> un assemblage</small></h1>
                    </div>
                </div>
            </div>
            
                <?php if ($errors->count() > 0) : ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-circle fa-fw fa-3x pull-left"></i>
                        <div style="margin-left: 70px">
                            <h4>Oups!</h4> L'assemblage n'a pu être <?php echo ($currentRoute == 'parts.assemblies.create') ? 'ajouté' : 'modifié'; ?>. Les erreurs suivants se sont produits:
                            <?php echo HTML::ul($errors->all()); ?>
                        </div>
                    </div>
                <?php endif; ?>
            
                <?php echo ($currentRoute == 'parts.assemblies.create') ? Form::open(array('route' => 'parts.assemblies.store')) : Form::model($assembly, array('route' => array('parts.assemblies.update', $assembly->id))); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning" ><i class="fa fa-save fa-fw"></i> <?php echo ($currentRoute == 'parts.assemblies.create') ? 'Ajouter l\'assemblage' : 'Enregistrer les modifications'; ?></button>
                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo ($currentRoute == 'parts.assemblies.create') ? route('parts.projects.view', $project->id) : route('parts.projects.view', $project->id); ?>" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Annuler</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        
                        <div class="col-sm-8 col-sm-offset-2 col-xs-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#form-info" role="tab" data-toggle="tab"><i class="fa fa-folder-open-o fa-fw"></i> Informations</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="form-info">
                                    <div class="panel panel-default panel-tabs">
                                        <div class="panel-body">
                                            <dl>
                                            	
                                                <dt><label>Nom de l'assemblage</label></dt>
                                                <dd><?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Nom de l\'assemblage...', 'id' => 'title')); ?></dd>
                                                
                                                <dt><label>Gestionnaire de l'assemblage</label></dt>
                                                <dd>
                                                	<?php $managers_array = array('Élèves' => array(), 'Mentors et apprentis mentors' => array()); 
                                                	foreach ($managers as $manager) 
													{
														if ($manager->is_mentor || $manager->is_junior_mentor) 	$managers_array['Mentors et apprentis mentors'][$manager->id] = $manager->full_name;
														if ($manager->is_student) 								$managers_array['Élèves'][$manager->id] = $manager->full_name;
													}
													?>
                                                	<?php echo Form::select('manager_id', $managers_array, 1, array('class' => 'form-control', 'id' => 'manager_id')); ?>
                                                </dd>
                                                
                                                <dt><label>Code de l'assemblage</label></dt>
                                                <dd><?php echo Form::text('code', null, array('class' => 'form-control', 'placeholder' => 'Code de l\'assemblage...', 'id' => 'code', 'maxlength' => '1')); ?></dd>
                                                
                                                <dt><label>Description</label></dt>
                                                <dd><?php echo Form::textarea('desc', null, array('class' => 'form-control', 'placeholder' => 'Description de l\'assemblage...', 'id' => 'desc')); ?></dd>
                                                
                                                <dt><label>Dans le projet</label></dt>
                                                <dd><?php echo Form::hidden('project_id', $project->id); ?><i class="fa fa-briefcase fa-fw"></i> <?php echo $project->title; ?></dd>
                                                
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                <?php echo Form::close(); ?>
                
                <script type="text/javascript">
                $('.toggle-tooltip').tooltip({container: 'body'});
                </script>
                
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
            
            $(function() {
                $('#manager_id').selectize({
                    create: false,
                    valueField: 'id',
                    labelField: 'full_name',
                    searchField: 'full_name'
                });
            });
            
            </script>
        @stop
        
    @stop
