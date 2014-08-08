@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Sous-assemblages
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
                        <h1><i class="fa fa-cube fa-fw"></i> Sous-assemblages <small><?php echo ($currentRoute == 'parts.subassemblies.create') ? 'Ajouter' : 'Modifier'; ?> un sous-assemblage</small></h1>
                    </div>
                </div>
            </div>
            
                <?php if ($errors->count() > 0) : ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-circle fa-fw fa-3x pull-left"></i>
                        <div style="margin-left: 70px">
                            <h4>Oups!</h4> Le sous-assemblage n'a pu être <?php echo ($currentRoute == 'parts.subassemblies.create') ? 'ajouté' : 'modifié'; ?>. Les erreurs suivants se sont produits:
                            <?php echo HTML::ul($errors->all()); ?>
                        </div>
                    </div>
                <?php endif; ?>
            
                <?php echo ($currentRoute == 'parts.subassemblies.create') ? Form::open(array('route' => 'parts.subassemblies.store')) : Form::model($subassembly, array('route' => array('parts.subassemblies.update', $subassembly->id))); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning" ><i class="fa fa-save fa-fw"></i> <?php echo ($currentRoute == 'parts.subassemblies.create') ? 'Ajouter l\'assemblage' : 'Enregistrer les modifications'; ?></button>
                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo ($currentRoute == 'parts.subassemblies.create') ? route('parts.assemblies.view', $assembly->id) : route('parts.subassemblies.view', $subassembly->id); ?>" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Annuler</a>
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
                                            	
                                                <dt><label>Nom du sous-assemblage</label></dt>
                                                <dd><?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Nom du sous-assemblage...', 'id' => 'title')); ?></dd>
                                                
                                                <dt><label>Code du sous-assemblage</label></dt>
                                                <dd>
                                                	<div class="input-group col-xs-3">
                                                		<span class="input-group-addon">CRA-<?php echo $assembly->code; ?></span>
                                                		<?php echo Form::text('code', null, array('class' => 'form-control text-center', 'placeholder' => '00', 'id' => 'code', 'maxlength' => '2')); ?>
                                                		<span class="input-group-addon">00</span>
                                                	</div>
                                                </dd>
                                                
                                                <dt><label>Description</label></dt>
                                                <dd><?php echo Form::textarea('desc', null, array('class' => 'form-control', 'placeholder' => 'Description du sous-assemblage...', 'id' => 'desc')); ?></dd>
                                                
                                                <dt><label>Dans l'assemblage</label></dt>
                                                <dd>
                                                	<?php echo Form::hidden('assembly_id', $assembly->id); ?>
                                                	<span class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $project->title; ?></span> 
                                                	<i class="fa fa-angle-right fa-fw"></i> 
                                                	<span class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></span>
                                                </dd>
                                                
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
