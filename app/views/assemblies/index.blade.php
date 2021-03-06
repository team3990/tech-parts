@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Assemblages
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
						<li><a href="<?php echo route('parts.projects.index'); ?>">Projets</a></li>
						<li><a href="<?php echo route('parts.projects.view', $assembly->project->id); ?>"><i class="fa fa-briefcase fa-fw"></i> <?php echo $assembly->project->title; ?></a></li>
						<li class="active"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></li>
					</ol>
					
					<span class="pull-right text-muted">Gestionnaire d'assemblage: <i class="fa fa-user fa-fw"></i> <?php echo $assembly->manager->full_name; ?></span>
					
                    <div class="page-header">
                        <h1>
                        	<i class="fa fa-cubes fa-fw"></i> 
                        	<kbd><?php echo $assembly->nomenclature; ?></kbd> 
                        	<?php echo ($currentRoute == 'parts.assemblies.view') ? $assembly->title.' <br /><small>'.$assembly->desc.'</small>' : 'Assemblages <small>Tous les assemblages</small>'; ?></h1>
                    </div>
					                    
                </div>
            </div>
            
            <?php if ($currentRoute == 'parts.assemblies.view') : ?>
				<div class="row">
	                <div class="col-xs-12">
	                    <div class="btn-toolbar" role="toolbar">
	                    
	                    	<div class="btn-group">
	                    		<a href="<?php echo route('parts.projects.view', $assembly->project->id); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left fa-fw"></i> Retourner au projet</a>
	                    	</div>
	                    	
	                        <div class="btn-group">
	                            <a href="<?php echo route('parts.assemblies.edit', $assembly->id); ?>" class="btn btn-default"><i class="fa fa-pencil-square-o fa-fw"></i> Modifier l'assemblage</a>
                            </div>
                            <div class="btn-group">
	                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-destroy-<?php echo $assembly->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer l'assemblage</button>
	                        </div>
	                        <div class="modal fade" id="modal-destroy-<?php echo $assembly->id; ?>" tabindex="-1" role="dialog">
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
	                                                    <h4 style="margin-top: 0"><kbd><?php echo $assembly->nomenclature; ?></kbd> <?php echo $assembly->title; ?></h4>
	                                                    <?php echo $assembly->desc; ?><br />
	                                                    Responsable: <i class="fa fa-user fa-fw"></i> <?php echo $assembly->manager->full_name; ?><br />
	                                                    Dans <strong class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $assembly->project->title; ?></strong>
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
	                                <h4>Assemblage créé</h4> L'assemblage &laquo; <strong><?php echo strip_tags($assembly->title); ?></strong> &raquo; a été créé avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
	                    <?php if (Session::has('update') && Session::get('update') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Assemblage modifié</h4> L'assemblage &laquo; <strong><?php echo strip_tags($assembly->title); ?></strong> &raquo; a été modifié avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
	                    <?php if (Session::has('destroy') && Session::get('destroy') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Sous-assemblage supprimé</h4> Le sous-assemblage &laquo; <strong><?php echo strip_tags(Session::get('object_name')); ?></strong> &raquo; a été supprimé avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
            			<h4><?php echo count($assembly->subassemblies); ?> <?php echo (count($assembly->subassemblies) > 1) ? 'sous-assemblages' : 'sous-assemblage'; ?> dans l'assemblage <span class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></span></h4>
            			
            			<div class="row">
			                <div class="col-xs-12">
			                    <div class="btn-toolbar" role="toolbar">
			                        <div class="btn-group">
			                            <a href="<?php echo route('parts.subassemblies.create', $assembly->id); ?>" class="btn btn-default"><i class="fa fa-plus fa-fw"></i> Ajouter un sous-assemblage</a>
			                        </div>
			                    </div>
			                </div>
			            </div>
	            
            			<table class="table table-hover">
            				<thead>
            					<tr>
            						<th class="text-center" style="width: 100px;">Code</th>
            						<th style="width: 200px;">Nom du sous-assemblage</th>
            						<th>Description</th>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<th style="width: 200px">Actions</th>
            						<?php endif; ?>
            					</tr>
            				</thead>
            				<tbody>
            					<?php foreach ($assembly->subassemblies as $subassembly) : ?>
            					<tr>
            						<td class="text-center"><kbd><?php echo $subassembly->nomenclature; ?></kbd></td>
            						<td><a href="<?php echo route('parts.subassemblies.view', $subassembly->id); ?>"><i class="fa fa-cube fa-fw"></i> <?php echo $subassembly->title; ?></a></td>
            						<td class="small"><?php echo $subassembly->desc; ?></td>
            						<?php if (Auth::user()->is_mentor || Auth::user()->is_junior_mentor) : ?>
            						<td>
            							<a href="<?php echo route('parts.subassemblies.edit', $subassembly->id); ?>" class="btn btn-default btn-xs"><i class="fa fa-pencil fa-fw"></i> Modifier</a> 
	            						<button class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-destroy-subassembly-<?php echo $subassembly->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer</button>
				                        <div class="modal fade" id="modal-destroy-subassembly-<?php echo $subassembly->id; ?>" tabindex="-1" role="dialog">
				                            <div class="modal-dialog">
				                                <div class="modal-content">
				                                    <div class="modal-header">
				                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				                                        <h4 class="modal-title" id="myModalLabel">Supprimer un sous-assemblage</h4>
				                                    </div>
				                                    <div class="modal-body">
				                                        <div class="panel panel-default">
				                                            <div class="panel-body">
				                                                <i class="fa fa-cube fa-fw fa-3x pull-left"></i>
				                                                <div style="margin-left: 70px">
				                                                    <h4 style="margin-top: 0"><kbd><?php echo $subassembly->nomenclature; ?></kbd> <?php echo $subassembly->title; ?></h4>
				                                                    <?php echo $subassembly->desc; ?><br />
				                                                    Dans <strong class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $subassembly->assembly->project->title; ?></strong> 
				                                                    <i class="fa fa-angle-right fa-fw"></i> 
				                                                    <strong class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $subassembly->assembly->title; ?></strong>
				                                                </div>
				                                            </div>
				                                        </div>
				                                        <div class="text-danger text-center"><strong>Êtes-vous sûr de vouloir supprimer ce sous-assemblage?</strong></div>
				                                    </div>
				                                    <div class="modal-footer">
				                                        <a href="<?php echo route('parts.subassemblies.destroy', $subassembly->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</a>
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
            			<?php if (count($assembly->subassemblies) == 0) : ?>
	            			<div class="alert alert-warning text-center">Aucun sous-assemblage disponible dans l'assemblage <strong class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $assembly->title; ?></strong> pour le moment.</div>
						<?php endif; ?>
            		</div>
            	</div>
            	
            <?php else : ?>
	            
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
