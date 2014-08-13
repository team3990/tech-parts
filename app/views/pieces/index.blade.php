@extends('layout.master') 

    @section('head')
        
        @parent
        
        {{-- HTML Header Section --}}
        @section('title')
            Pièces
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
						<li><a href="<?php echo route('parts.projects.view', $piece->subassembly->assembly->project->id); ?>"><i class="fa fa-briefcase fa-fw"></i> <?php echo $piece->subassembly->assembly->project->title; ?></a></li>
						<li><a href="<?php echo route('parts.assemblies.view', $piece->subassembly->assembly->id); ?>"><i class="fa fa-cubes fa-fw"></i> <?php echo $piece->subassembly->assembly->title; ?></a></li>
						<li><a href="<?php echo route('parts.subassemblies.view', $piece->subassembly->id); ?>"><i class="fa fa-cube fa-fw"></i> <?php echo $piece->subassembly->title; ?></a></li>
						<li class="active"><i class="fa fa-cog fa-fw"></i> <?php echo $piece->title; ?></li>
					</ol>
					
					<span class="pull-right text-muted">Gestionnaire d'assemblage: <i class="fa fa-user fa-fw"></i> <?php echo $piece->subassembly->assembly->manager->full_name; ?></span>
					
                    <div class="page-header">
                        <h1>
                        	<i class="fa fa-cog fa-fw"></i> 
                        	<kbd><?php echo $piece->nomenclature; ?></kbd> 
                        	<?php echo ($currentRoute == 'parts.pieces.view') ? $piece->title : 'Pièces <small>Toutes les pièces</small>'; ?></h1>
                    </div>
					                    
                </div>
            </div>
            
            <?php if ($currentRoute == 'parts.pieces.view') : ?>
				<div class="row">
	                <div class="col-xs-12">
	                    <div class="btn-toolbar" role="toolbar">
	                    
	                    	<div class="btn-group">
	                    		<a href="<?php echo route('parts.subassemblies.view', $piece->subassembly->id); ?>" class="btn btn-default"><i class="fa fa-arrow-circle-left fa-fw"></i> Retourner au sous-assemblage</a>
	                    	</div>
	                    	
	                        <div class="btn-group">
	                            <a href="<?php echo route('parts.pieces.edit', $piece->id); ?>" class="btn btn-default"><i class="fa fa-pencil-square-o fa-fw"></i> Modifier la pièce</a>
                            </div>
                            <div class="btn-group">
	                            <button class="btn btn-default" data-toggle="modal" data-target="#modal-destroy-<?php echo $piece->id; ?>"><i class="fa fa-trash-o fa-fw"></i> Supprimer la pièce</button>
	                        </div>
	                        <div class="modal fade" id="modal-destroy-<?php echo $piece->id; ?>" tabindex="-1" role="dialog">
	                            <div class="modal-dialog">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                                        <h4 class="modal-title" id="myModalLabel">Supprimer une pièce</h4>
	                                    </div>
	                                    <div class="modal-body">
	                                        <div class="panel panel-default">
	                                            <div class="panel-body">
	                                                <i class="fa fa-cog fa-fw fa-3x pull-left"></i>
	                                                <div style="margin-left: 70px">
	                                                    <h4 style="margin-top: 0"><kbd><?php echo $piece->nomenclature; ?></kbd> <?php echo $piece->title; ?></h4>
	                                                    <?php echo $piece->desc; ?><br />
	                                                    Dans <strong class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $piece->subassembly->assembly->project->title; ?></strong> 
	                                                    <i class="fa fa-angle-right fa-fw"></i> 
	                                                    <strong class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $piece->subassembly->assembly->title; ?></strong> 
	                                                    <i class="fa fa-angle-right fa-fw"></i> 
	                                                    <strong class="bg-info"><i class="fa fa-cube fa-fw"></i> <?php echo $piece->subassembly->title; ?></strong>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="text-danger text-center"><strong>Êtes-vous sûr de vouloir supprimer cette pièce?</strong></div>
	                                    </div>
	                                    <div class="modal-footer">
	                                        <a href="<?php echo route('parts.pieces.destroy', $piece->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Supprimer</a>
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
	                                <h4>Pièce créée</h4> La pièce &laquo; <strong><?php echo strip_tags($piece->title); ?></strong> &raquo; a été créée avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
	                    <?php if (Session::has('update') && Session::get('update') == true) : ?>
	                        <div class="alert alert-success alert-dismissable fade in">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <i class="fa fa-check-circle fa-fw fa-3x pull-left"></i>
	                            <div style="margin-left: 70px">
	                                <h4>Pièce modifiée</h4> La pièce &laquo; <strong><?php echo strip_tags($piece->title); ?></strong> &raquo; a été modifiée avec succès.
	                            </div>
	                        </div>
	                    <?php endif; ?>
	                    
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
                                                <dd><?php echo (empty($piece->title)) ? '<em class="text-muted">Aucun nom.</em>' : $piece->title; ?></dd>
                                                
                                                <dt><label for="code">Code de la pièce</label></dt>
                                                <dd><kbd><?php echo (empty($piece->nomenclature)) ? '<em class="text-muted">Aucun code.</em>' : $piece->nomenclature; ?></kbd></dd>
                                                
                                                <dt><label>Type de la pièce</label></dt>
                                                <dd><span class="label label-default"><?php echo str_pad($piece->type->id, 2, '0', STR_PAD_LEFT); ?></span> <?php echo $piece->type->title; ?></dd>
                                                
                                                <?php if (in_array($piece->type->id, array(1, 2))) : ?>
                                                <dt><label for="author_id">Auteur de la pièce</label></dt>
                                                <dd><?php echo ($piece->author == NULL) ? '<em class="text-muted">Aucun auteur.</em>' : $piece->author->full_name; ?></dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="desc">Description</label></dt>
                                                <dd><?php echo (empty($piece->desc)) ? '<em class="text-muted">Aucune description.</em>' : $piece->desc; ?></dd>
                                                
                                                <dt><label>Dans le sous-assemblage</label></dt>
                                                <dd>
                                                	<span class="bg-info"><i class="fa fa-briefcase fa-fw"></i> <?php echo $piece->subassembly->assembly->project->title; ?></span> 
                                                	<i class="fa fa-angle-right fa-fw"></i> 
                                                	<span class="bg-info"><i class="fa fa-cubes fa-fw"></i> <?php echo $piece->subassembly->assembly->title; ?></span> 
                                                	<i class="fa fa-angle-right fa-fw"></i> 
                                                	<span class="bg-info"><i class="fa fa-cube fa-fw"></i> <?php echo $piece->subassembly->title; ?></span> 
                                                </dd>
                                                
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-xs-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#form-info" role="tab" data-toggle="tab"><i class="fa fa-cog fa-fw"></i> <span class="label label-default"><?php echo str_pad($piece->type->id, 2, '0', STR_PAD_LEFT); ?></span> <?php echo $piece->type->title; ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="form-info">
                                    <div class="panel panel-default panel-tabs">
                                        <div class="panel-body">
                                            <dl>
                                                
                                                <?php if (in_array($piece->type->id, array(2, 3))) : ?>
                                                <dt><label for="provider_id">Fournisseur</label></dt>
                                                <dd><?php echo ($piece->provider == NULL) ? '<em class="text-muted">Aucun fournisseur.</em>' : $piece->provider->title; ?></dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="datetime_due">Date due</label></dt>
                                                <dd><?php echo ($piece->datetime_due == NULL || $piece->datetime_due == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_due))); ?></dd>
                                                
                                                <?php if (in_array($piece->type->id, array(2))) : ?>
                                                <dt><label for="datetime_tosend">Date à envoyer au fournisseur</label></dt>
                                                <dd><?php echo ($piece->datetime_tosend == NULL || $piece->datetime_tosend == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_tosend))); ?></dd>
                                                
                                                <dt><label for="datetime_sent">Date envoyée au fournisseur</label></dt>
                                                <dd><?php echo ($piece->datetime_sent == NULL || $piece->datetime_sent == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_sent))); ?></dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece->type->id, array(2, 3))) : ?>
                                                <dt><label for="datetime_toreceive">Date à recevoir du fournisseur</label></dt>
                                                <dd><?php echo ($piece->datetime_toreceive == NULL || $piece->datetime_toreceive == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_toreceive))); ?></dd>
                                                
                                                <dt><label for="datetime_received">Date reçue du fournisseur</label></dt>
                                                <dd><?php echo ($piece->datetime_received == NULL || $piece->datetime_received == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_received))); ?></dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece->type->id, array(3))) : ?>
                                                <dt><label for="datetime_toorder">Date à commander</label></dt>
                                                <dd><?php echo ($piece->datetime_toorder == NULL || $piece->datetime_toorder == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_toorder))); ?></dd>
                                                
                                                <dt><label for="datetime_ordered">Date commandée</label></dt>
                                                <dd><?php echo ($piece->datetime_ordered == NULL || $piece->datetime_ordered == '0000-00-00 00:00:00') ? '<em class="text-muted">Aucune date.</em>' : mb_strtolower(strftime('Le %A %e %B %Y', strtotime($piece->datetime_ordered))); ?></dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece->type->id, array(1))) : ?>
                                                <dt><label for="material">Matériel</label></dt>
                                                <dd><?php echo ($piece->material == NULL) ? '<em class="text-muted">Aucun matériel.</em>' : $piece->material; ?></dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece->type->id, array(2, 3))) : ?>
                                                <dt><label for="unit_price">Prix unitaire</label></dt>
                                                <dd><?php echo ($piece->unit_price == NULL) ? '<em class="text-muted">Aucun prix unitaire.</em>' : number_format($piece->unit_price, 2, ',', ' ').' $'; ?></dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="material">Quantité</label></dt>
                                                <dd><?php echo ($piece->quantity == NULL) ? '<em class="text-muted">Aucune quantité.</em>' : number_format($piece->quantity, 0, ',', ' '); ?></dd>
                                                
                                                <?php if (in_array($piece->type->id, array(2, 3))) : ?>
                                                <dt><label for="invoice">Facture</label></dt>
                                                <dd>
                                                	<?php echo ($piece->invoice == NULL) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->invoice_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->invoice.'</a>'; ?>
                                                	<?php echo ($piece->invoice == NULL) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->invoice_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <?php if (in_array($piece->type->id, array(2))) : ?>
                                                <dt><label for="quote">Soumission du fournisseur</label></dt>
                                                <dd>
                                                	<?php echo ($piece->quote == NULL) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->quote_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->quote.'</a>'; ?>
                                                	<?php echo ($piece->quote == NULL) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->quote_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
                                                </dd>
                                                <?php endif; ?>
                                                
                                                <dt><label for="technical_drawing">Dessin technique</label></dt>
                                                <dd>
                                                	<?php echo ($piece->technical_drawing == NULL) ? '<em class="text-muted">Aucun fichier disponible.</em>' : '<a href="'.url($piece->technical_drawing_path).'" target="_blank"><i class="fa fa-cloud-download fa-fw"></i> '.$piece->technical_drawing.'</a>'; ?>
                                                	<?php echo ($piece->technical_drawing == NULL) ? '' : '<span class="text-muted">('.number_format(round(File::size(public_path().$piece->technical_drawing_path) / 1024), 0, ',', ' ').' Ko)</span>'; ?>
                                                </dd>
                                                
                                                <?php if (in_array($piece->type->id, array(3))) : ?>
                                                <dt><label for="external_link">Lien Web de la pièce</label></dt>
                                                <dd><?php echo ($piece->external_link == NULL) ? '<em class="text-muted">Aucun lien Web.</em>' : $piece->external_link; ?></dd>
                                                <?php endif; ?>
                                                
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
