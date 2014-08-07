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
                
                	<ol class="breadcrumb">
						<li<?php echo ($currentRoute == 'parts.projects.view') ? '' : ' class="active"' ?>><a href="<?php echo route('parts.projects.index'); ?>">Projets</a></li>
						<?php if ($currentRoute == 'parts.projects.view') : ?>
						<li class="active"><i class="fa fa-briefcase fa-fw"></i> <?php echo $project->title; ?></li>
						<?php endif; ?>
					</ol>
					
                    <div class="page-header">
                        <h1><i class="fa fa-briefcase fa-fw"></i> <?php echo ($currentRoute == 'parts.projects.view') ? $project->title.' <small>'.$project->desc.'</small>' : 'Projets <small>Tous les projets</small>'; ?></h1>
                    </div>
                    
                </div>
            </div>
            
            <?php if ($currentRoute == 'parts.projects.view') : ?>
            	<div class="row">
	                <div class="col-xs-12">
	                    <div class="btn-toolbar" role="toolbar">
	                    	
	                        <?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
	                        <div class="btn-group">
	                            <a href="<?php echo route('parts.projects.edit', $project->id); ?>" class="btn btn-default"><i class="fa fa-pencil-square-o fa-fw"></i> Modifier le projet</a>
                            </div>
                            <div class="btn-group">
	                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-destroy-<?php echo $project->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer le projet</button>
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
	                    
	                    <?php if (Session::has('destroy') && Session::get('destroy') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Assemblage supprimé</h4> L'assemblage &laquo; <strong><?php echo strip_tags(Session::get('object_name')); ?></strong> &raquo; a été supprimé avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
            			<h4><?php echo count($project->assemblies); ?> <?php echo (count($project->assemblies) > 1) ? 'assemblages' : 'assemblage'; ?> dans ce projet</h4>
            			
            			<div class="row">
			                <div class="col-xs-12">
			                    <div class="btn-toolbar" role="toolbar">
			                        <div class="btn-group">
			                            <a href="<?php echo route('parts.assemblies.create', $project->id); ?>" class="btn btn-default"><i class="fa fa-plus fa-fw"></i> Ajouter un assemblage</a>
			                        </div>
			                    </div>
			                </div>
			            </div>
	            
            			<table class="table table-hover">
            				<thead>
            					<tr>
            						<th>Nom de l'assemblage</th>
            						<th>Description</th>
            						<th>Code</th>
            						<th>Gestionnaire d'assemblage</th>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<th style="width: 200px">Actions</th>
            						<?php endif; ?>
            					</tr>
            				</thead>
            				<tbody>
            					<?php foreach ($project->assemblies as $assembly) : ?>
            					<tr>
            						<td><a href="<?php echo route('parts.assemblies.view', $assembly->id); ?>"><?php echo $assembly->title; ?></a></td>
            						<td><?php echo $assembly->desc; ?></td>
            						<td><kbd>CRA-<?php echo $assembly->code; ?></kbd></td>
            						<td><i class="fa fa-user fa-fw"></i> <?php echo $assembly->manager->full_name; ?></td>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<td>
            							<a href="<?php echo route('parts.assemblies.edit', $assembly->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-fw"></i> Modifier</a> 
	            						<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-destroy-assembly-<?php echo $assembly->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
				                        <div class="modal fade" id="modal-destroy-assembly-<?php echo $assembly->id; ?>" tabindex="-1" role="dialog">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                                        <h4 class="modal-title" id="myModalLabel">Supprimer un assemblage</h4>
				                                    </div>
				                                    <div class="modal-body">
				                                        <div class="panel panel-default">
				                                            <div class="panel-body">
				                                                <i class="fa fa-cubes fa-fw fa-3x pull-left"></i>
				                                                <div style="margin-left: 70px">
				                                                    <h4 style="margin-top: 0"><?php echo $assembly->title; ?></h4>
				                                                    <?php echo $assembly->desc; ?><br />
				                                                    Responsable: <i class="fa fa-user fa-fw"></i> <?php echo $assembly->manager->full_name; ?><br />
				                                                    Code d'assemblage: <?php echo $assembly->code; ?>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="text-danger text-center"><strong>Êtes-vous sûr de vouloir supprimer cet assemblage?</strong></div>
				                                    </div>
				                                    <div class="modal-footer">
				                                        <a href="<?php echo route('parts.assemblies.destroy', $assembly->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</a>
				                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle fa-fw"></i> Annuler</button>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
            						</td>
            						<?php endif; ?>
            					</tr>
            					<?php endforeach; ?>
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
