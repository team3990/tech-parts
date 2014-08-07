@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Projets
        @stop
        
        @section('stylesheets')
            @parent
        @stop
        
        @section('scripts_header')
            @parent
        @stop
        
    @stop

    {{-- HTML Body Section --}}
    @section('body')
    
        @parent
    
        @section('content')
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header">
                        <h1><i class="fa fa-briefcase fa-fw"></i> Projets <small><?php echo ($currentRoute == 'parts.projects.create') ? 'Ajouter' : 'Modifier'; ?> un projet</small></h1>
                    </div>
                </div>
            </div>
            
            <?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            
                <?php if ($errors->count() > 0) : ?>
                    <div class="alert alert-danger alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-exclamation-circle fa-fw fa-3x pull-left"></i>
                        <div style="margin-left: 70px">
                            <h4>Oups!</h4> Le projet n'a pu être <?php echo ($currentRoute == 'parts.projects.create') ? 'ajouté' : 'modifié'; ?>. Les erreurs suivants se sont produits:
                            <?php echo HTML::ul($errors->all()); ?>
                        </div>
                    </div>
                <?php endif; ?>
            
                <?php echo ($currentRoute == 'parts.projects.create') ? Form::open(array('route' => 'parts.projects.store', 'files' => true)) : Form::model($project, array('route' => array('parts.projects.update', $project->id))); ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-warning" ><i class="fa fa-save fa-fw"></i> <?php echo ($currentRoute == 'parts.projects.create') ? 'Ajouter le projet' : 'Enregistrer les modifications'; ?></button>
                                </div>
                                <div class="btn-group">
                                    <a href="<?php echo ($currentRoute == 'parts.projects.create') ? route('parts.projects.index') : route('parts.projects.view', array($project->id)); ?>" class="btn btn-default"><i class="fa fa-times fa-fw"></i> Annuler</a>
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
                                                <dt><label>Nom du projet</label></dt>
                                                <dd><?php echo Form::text('title', null, array('class' => 'form-control', 'placeholder' => 'Nom du projet...', 'id' => 'title')); ?></dd>
                                                
                                                <dt><label>Description</label></dt>
                                                <dd><?php echo Form::textarea('desc', null, array('class' => 'form-control', 'placeholder' => 'Description du projet...', 'id' => 'desc')); ?></dd>
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
                
            <?php else : ?>
            <div class="row">
                <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-3 col-xs-12">
                    <div class="alert alert-danger text-center">Vous n'avez pas les droits d'administrateur pour effectuer cette opération.</div>
                </div>
            </div>
            <?php endif; ?>
        @stop
        
    @stop
    
    @section('footer')
        
        @parent 
        
        @section('footer-content')
            @parent
        @stop
    
        @section('scripts_eof')
            @parent
        @stop
        
    @stop
