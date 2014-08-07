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
                <div class="col-xs-12">
                    <div class="page-header">
                        <h1><i class="fa fa-briefcase fa-fw"></i> Projets <small><?php echo ($currentRoute == 'parts.projects.view') ? 'Voir un projet' : 'Tous les projets'; ?></small></h1>
                    </div>
                </div>
            </div>
            
            <?php if ($currentRoute == 'parts.projects.view') : ?>
            	<div class="row">
	                <div class="col-xs-12">
	                    <div class="btn-toolbar" role="toolbar">
	                    	
	                    	<div class="btn-group">
	                    		<a href="<?php echo route('parts.projects.index'); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left fa-fw"></i> Retourner à la liste des projets</a>
	                    	</div>
	                    	
	                        <?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
	                        <div class="btn-group">
	                            <a href="<?php echo route('parts.projects.edit', $project->id); ?>" class="btn btn-default"><i class="fa fa-pencil-square-o fa-fw"></i> Modifier le projet</a>
                            </div>
                            <div class="btn-group">
	                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-destroy-<?php echo $project->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
	                        </div>
	                        <div class="modal fade" id="modal-destroy-<?php echo $project->id; ?>" tabindex="-1" role="dialog">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                                        <h4 class="modal-title" id="myModalLabel">Supprimer un projet</h4>
	                                    </div>
	                                    <div class="modal-body">
	                                        <div class="panel panel-default">
	                                            <div class="panel-body">
	                                                <i class="fa fa-briefcase fa-fw fa-3x pull-left"></i>
	                                                <div style="margin-left: 70px">
	                                                    <h4 style="margin-top: 0"><?php echo $project->title; ?></h4>
	                                                    <?php echo $project->desc; ?>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="text-danger text-center"><strong>Êtes-vous sûr de vouloir supprimer ce projet?</strong></div>
	                                    </div>
	                                    <div class="modal-footer">
	                                        <a href="<?php echo route('parts.projects.destroy', $project->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</a>
	                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Annuler</button>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <?php endif; ?>
	                        
	                    </div>
	                </div>
	            </div>
	            
            	<div class="row">
            		<div class="col-xs-12">
            		
            			<?php if (Session::has('store') && Session::get('store') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Projet créé</h4> Le projet &laquo; <strong><?php echo strip_tags($project->title); ?></strong> &raquo; a été créé avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
	                    <?php if (Session::has('update') && Session::get('update') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Projet modifié</h4> Le projet &laquo; <strong><?php echo strip_tags($project->title); ?></strong> &raquo; a été modifié avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
            			<h3><?php echo $project->title; ?></h3>
            			<p class="lead"><?php echo $project->desc; ?></p>
            			<hr />
            			<h4>Assemblage(s) dans ce projet</h4>
            			<table class="table table-hover">
            				<thead>
            					<tr>
            						<th>Nom de l'assemblage</th>
            						<th>Description</th>
            						<th>Nomenclature</th>
            						<th>Gestionnaire d'assemblage</th>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<th style="width: 200px">Actions</th>
            						<?php endif; ?>
            					</tr>
            				</thead>
            				<tbody>
            					<?php /* foreach ($project->assemblies as $assembly) : ?>
            					<tr>
            						<td><?php echo $assembly->title; ?></td>
            						<td><?php echo $assembly->desc; ?></td>
            						<td><?php echo $assembly->code; ?></td>
            						<td></td>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<td>
            							<a href="#" class="btn btn-sm"><i class="fa fa-pencil fa-fw"></i></a> 
	            						<a href="#" class="btn btn-sm"><i class="fa fa-trash-o fa-fw"></i></a>
            						</td>
            						<?php endif; ?>
            					</tr>
            					<?php endforeach; */ ?>
            				</tbody>
            			</table>
            			<?php if (count($project->assemblies) == 0) : ?>
	            			<div class="alert alert-warning text-center">Aucun assemblage disponible dans ce projet pour le moment.</div>
						<?php endif; ?>
            		</div>
            	</div>
            	
            <?php else : ?>
	            <div class="row">
	                <div class="col-xs-12">
	                    <div class="btn-toolbar" role="toolbar">
	                    
	                        <?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
	                        <div class="btn-group">
	                            <a href="<?php echo route('parts.projects.create'); ?>" class="btn btn-default"><i class="fa fa-plus fa-fw"></i> Ajouter un projet</a>
	                        </div>
	                        <?php endif; ?>
	                        
	                    </div>
	                </div>
	            </div>
	            
	            <div class="row">
	            	<div class="col-xs-12">
	            		
	            		<?php if (Session::has('destroy') && Session::get('destroy') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Projet supprimé</h4> Le projet &laquo; <strong><?php echo strip_tags(Session::get('object_name')); ?></strong> &raquo; a été supprimé avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
                    
	            		<table class="table table-hover">
	            			<thead>
	            				<tr>
	            					<th>Nom</th>
	            					<th>Description</th>
	            					<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
	            					<th style="width: 200px">Actions</th>
	            					<?php endif; ?>
	            				</tr>
	            			</thead>
	            			<tbody>
	            				<?php foreach ($projects as $project) : ?>
	            				<tr>
	            					<td><a href="<?php echo route('parts.projects.view', $project->id); ?>"><?php echo $project->title; ?></a></td>
	            					<td><?php echo $project->desc; ?></td>
	            					<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
	            					<td>
	            						<a href="<?php echo route('parts.projects.edit', $project->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-fw"></i> Modifier</a> 
	            						<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-destroy-<?php echo $project->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
	            					</td>
	            					<div class="modal fade" id="modal-destroy-<?php echo $project->id; ?>" tabindex="-1" role="dialog">
			                            <div class="modal-dialog">
			                                <div class="modal-content">
			                                    <div class="modal-header">
			                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			                                        <h4 class="modal-title" id="myModalLabel">Supprimer un projet</h4>
			                                    </div>
			                                    <div class="modal-body">
			                                        <div class="panel panel-default">
			                                            <div class="panel-body">
			                                                <i class="fa fa-briefcase fa-fw fa-3x pull-left"></i>
			                                                <div style="margin-left: 70px">
			                                                    <h4 style="margin-top: 0"><?php echo $project->title; ?></h4>
			                                                    <?php echo $project->desc; ?>
			                                                </div>
			                                            </div>
			                                        </div>
			                                        <div class="text-danger text-center"><strong>Êtes-vous sûr de vouloir supprimer ce projet?</strong></div>
			                                    </div>
			                                    <div class="modal-footer">
			                                        <a href="<?php echo route('parts.projects.destroy', $project->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</a>
			                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Annuler</button>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
	            					<?php endif; ?>
	            				</tr>
	            				<?php endforeach; ?>
	            			</tbody>
	            		</table>
	            		<?php if (count($projects) == 0) : ?>
	            			<div class="alert alert-warning text-center">Aucun projet disponible pour le moment.</div>
						<?php endif; ?>
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
