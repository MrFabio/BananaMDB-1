	<link rel="stylesheet" href="<?php echo base_url();?>css/filme.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/jquery.rating.css">
		
	<script src='<?php echo base_url();?>js/jquery.MetaData.js' type="text/javascript" language="javascript"></script>
 <script src='<?php echo base_url();?>js/jquery.rating.js' type="text/javascript" language="javascript"></script>
 <link href='<?php echo base_url();?>js/jquery.rating.css' type="text/css" rel="stylesheet"/>


	<div id="feed-block" class="well">

	<?php
	$idfilme = $this->uri->segment(3);
	if ($idfilme==NULL)
		redirect(base_url());//se entra sem id no url vai para pagina principal
	
	if(is_numeric($idfilme)==TRUE)
				$query = $this->pesquisamodel->get_filmebyid($idfilme)->row();
			else
				redirect(base_url());
	

	if ($query == FALSE)//não existe filme com esse id
		redirect(base_url());

	$generoid = $this->pesquisamodel->get_generosbyfilme($idfilme)->result();

	$realizador = $this->pesquisamodel->get_realizadorLbyid($query->ID_REALIZADOR)->result();
	$produtora = $this->pesquisamodel->get_produtoraLbyid($query->ID_PRODUTORA)->result();
	$votos=$this->estmodel->get_Vfilme($idfilme);

	?>


	<script type="text/javascript">
		document.title = "<?= 'BananaMDB - ' . $query->TITULO;?>"
	</script>

	<div class="block">
		<!-- Button trigger modal -->
				<button class="btn btn-primary btn-lg btn-right" data-toggle="modal" data-target="#myModal">
				  Ver Trailer
				</button>
		<h2 class="title"><?php  echo $query->TITULO ; 
									if($query->OSCARES==1) echo "<span class = \"glyphicon glyphicon-star silver\" \\>"; 
									else if($query->OSCARES>1 && $query->OSCARES<100) echo "<span class = \"glyphicon glyphicon-star gold\" \\>"; 
									else if($query->OSCARES==100) echo "<span class = \"glyphicon\"> <img src=\"" . base_url() . "img/crown.png\"></a></span>";  ?> </h2>
		<hr>
		<!-- Main hero unit for a primary marketing message or call to action -->

		<div id="log-table">
			<div id="log-cell-1">
				<img class="img-thumbnail img-filme" src="<?php echo base_url() . 'uploads/posters/' . $query->POSTER;?>">
			</div>

			<div id="log-cell-2">

				<p class="destaque"><span class="destaque"></span> </p>	


				<div class="control-group" >
				<h4 class="inline">Realizador - </h4>
				<label class="control-group">
				<?php  $reals = '';
				foreach ($realizador as $linha) {
				$reals = $reals . '<a href=' .   base_url() . 'title/realizador/' . $linha->ID_REALIZADOR . '>' . $linha->NOME . '</a>';}
				echo $reals;?>
				</label>
				</div>


				<div class="control-group" >
				<h4 class="inline">Produtora - </h4>
				<label class="control-group">
				<?php  $prods = '';
				foreach ($produtora as $linha) {
				$prods = $prods . '<a href=' .   base_url() . 'title/produtora/' . $linha->ID_PRODUTORA . '>' . $linha->NOME . '</a>';}
				echo $prods;?>
				</label>

				</div>
				


				<div class="control-group" >
				<h4 class="inline">Género</h4>
				<label class="control-group">
				<?php $gens = '';
				foreach ($generoid as $linha) {
				$gens = $gens . ' - ' . '<a href=' .   base_url() . 'title/genero/' . $linha->ID_GENERO . '>' . $linha->NOME . '</a>' ;}
				echo $gens;?>
				</label>
				</div>     		


				<div class="control-group" >
				<h4 class="inline">ANO - </h4>
				<label class="control-group"><?php echo '<a href=' .   base_url() . 'title/ano/' . $query->ANO . '>' . $query->ANO . '</a>' ;?></label>
				</div>

				<div class="control-group" >
				<h4 class="inline">BUDGET - </h4>
				<label class="control-group"><?php if ($query->BUDGET>0) echo number_format($query->BUDGET,0,'.',' ') . ' €' ; else echo 'Sem Informações';?></label>
				</div>

				<div class="control-group" >
				<h4 class="inline">GROSS - </h4>
				<label class="control-group"><?php if ($query->GROSS>0) echo number_format($query->GROSS,0,'.',' ') . ' €' ; else echo 'Sem Informações';?></label>
				</div>

				<div class="control-group" >
				<h4 class="inline">ÓSCARES- </h4>
				<label class="control-group"><?php echo $query->OSCARES;?></label>
				</div>
				
				<div class="control-group" >
				<h4 class="inline">PRÉMIOS NOMEADO - </h4>
				<label class="control-group"><?php echo $query->PREMIOS_NOMEADO;?></label>
				</div>

				<div class="control-group" >
				<h4 class="inline">PRÉMIOS VENCIDOS - </h4>
				<label class="control-group"><?php echo $query->PREMIOS_VENCIDOS;?></label>
				</div>

								
				<div class="control-group" >
				<h4 class="inline">SINOPSE</h4><br>
				<label class="control-group"><?php echo $query->SINOPSE;?></label>
				</div>
				
	
				
				
				<div class="control-group" >
					<h4 class="inline">RATING - </h4>
						  <?php 	if( $query->RATING<=6)
						
						             echo '<span class="label label-default">' .  'TODOS' . '</span>';
						          else if( $query->RATING<=8)
						              echo '<span class="label label-primary">' .  $query->RATING . '</span>'; 
						          else if( $query->RATING<=12)
						              echo '<span class="label label-success">' .  $query->RATING . '</span>'; 
						          else if( $query->RATING<=16)
						              echo '<span class="label label-warning">' .  $query->RATING . '</span>'; 
						         else if( $query->RATING<=18)
						              echo '<span class="label label-danger">' .  $query->RATING . '</span>'; 
						
						         else 
						             echo '<span class="label label-xred">' .  'ADULTO' . '</span>';                                                   
						              
						              ?>
				</div>

			<div class="control-group" >
				<label class="control-group">
					<?php if(isset($this->pesquisamodel->getmediabyidview($idfilme)->row()->MEDIA))
								{$roww = $this->pesquisamodel->getmediabyidview($idfilme)->row();
								$media = $roww->MEDIA . '( ' . $roww->VOTOS . ' votos )';}
							else 
								$media = 'Sem Votos';
						echo $media;?>
					
					</label>
					
					
					
					<label class="control-group">
					<?php
					$fo = 'title/filme/' . $idfilme; if($ID_UTILIZADOR>0 ) echo form_open($fo);
					$media = number_format($roww->MEDIA,0,'.',' ');
					
					$votou = $this->pesquisamodel->getvotosfilmebyuser($idfilme,$ID_UTILIZADOR);
					//var_dump($votou);
					if($votou->num_rows()>0)
						$votou = $votou->row() -> PONTUACAO;
					else
						$votou = 0;
					
					
					
					if($ID_UTILIZADOR>0 && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="1"/>';
					else if($votou == 1)
						echo '<input name="star1" type="radio" class="star" value="1" disabled="disabled" checked="checked"/>';
					else if($media == 1 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="1" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="1" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="2"/>';
					else if($votou == 2)
						echo '<input name="star1" type="radio" class="star" value="2" disabled="disabled" checked="checked"/>';
					else if($media == 2 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="2" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="2" disabled="disabled"/>';
					
					
					
					if($ID_UTILIZADOR>0 && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="3"/>';
					else if($votou == 3)
						echo '<input name="star1" type="radio" class="star" value="3" disabled="disabled" checked="checked"/>';
					else if($media == 3 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="3" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="3" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0 && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="4"/>';
					else if($votou == 4)
						echo '<input name="star1" type="radio" class="star" value="4" disabled="disabled" checked="checked"/>';
					else if($media == 4 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="4" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="4" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0 && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="5"/>';
					else if($votou == 5)
						echo '<input name="star1" type="radio" class="star" value="5" disabled="disabled" checked="checked"/>';
					else if($media == 5 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="5" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="5" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="6"/>';
					else if($votou == 6)
						echo '<input name="star1" type="radio" class="star" value="6" disabled="disabled" checked="checked"/>';
					else if($media == 6  && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="6" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="6" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="7"/>';
					else if($votou == 7)
						echo '<input name="star1" type="radio" class="star" value="7" disabled="disabled" checked="checked"/>';
					else if($media == 7 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="7" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="7" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="8"/>';
					else if($votou == 8)
						echo '<input name="star1" type="radio" class="star" value="8" disabled="disabled" checked="checked"/>';
					else if($media == 8 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="8" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="8" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="9"/>';
					else if($votou == 9)
						echo '<input name="star1" type="radio" class="star" value="9" disabled="disabled" checked="checked"/>';
					else if($media == 9 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="9" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="9" disabled="disabled"/>';
					
					if($ID_UTILIZADOR>0  && $votou==0)
						echo '<input name="star1" type="radio" class="star" value="10"/>';
					else if($votou == 10)
						echo '<input name="star1" type="radio" class="star" value="10" disabled="disabled" checked="checked"/>';
					else if($media == 10 && $votou == 0)
						echo '<input name="star1" type="radio" class="star" value="10" disabled="disabled" checked="checked"/>';
					else
						echo '<input name="star1" type="radio" class="star" value="10" disabled="disabled"/>';
					
if($ID_UTILIZADOR>0 && $votou==0 ) {
	$attributes = 'class = "btn btn-success button"';
	echo form_submit('submit', 'Avaliar', $attributes); //echo form_input(array('name'=>'required star0','class'=>'required star','type'=>'radio'));
	echo form_close();}?>
</label>
				</div>
				
				
				
				<div id="vfilme" width='100%' style="height:200px;"></div>

				<!-- Modal -->
				<div class="modal fade block" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				        <h4 class="modal-title" id="myModalLabel"><?php  echo $query->TITULO ?></h4>
				      </div>
				      <div class="modal-body">
				        <?php
							if($query->RATING >= 18){

								if($idade>0){//Está logado
									if($idade>=18 && $idade<21)//maiores de 18 e menores de 21
										echo "<iframe width=\"100%\" src=\"//www.youtube.com/embed/<?php echo $query->TRAILER ?>\" frameborder=\"0\"></iframe>";
									else 
										if($idade>=21)//para adultos
											echo "<iframe src=\"http://flashservice.xvideos.com/embedframe/$query->TRAILER\" frameborder=0 width=100% scrolling=no></iframe>";
										else//não tem idade e está logado
											echo "Não tem idade para ver";
								}
								else 
									echo "Conteúdo Susceptível de ferir a sensibilidade dos visitantes.";//Não está logado
							}
							else 
								echo "<iframe width=\"100%\" height=\"315\" src=\"//www.youtube.com/embed/$query->TRAILER\" frameborder=\"0\"></iframe>";
						?>
				      </div>
				    </div><!-- /.modal-content -->
				  </div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

				

			</div>
		</div>
		<div id="cast" class="panel panel-info">
			<div class="panel-heading">Cast</div>
				<?php $filmes = $this->pesquisamodel->get_actoresbyfilmeid($query->ID_FILME)->result();
					$nada = '0 Resultados';
					$cfilmes=0;
					foreach ($filmes as $linha) {
						if($linha==NULL)
							break;
						$this->table->add_row( '<a href=' .   base_url() . 'title/actor/' . $linha->ID_ACTOR . '><img src="' . base_url() . 'uploads/actores/' . $linha->IMAGEM . '" width="50px" height="auto""></a>',
						$linha->PERSONAGEM . ' - <a href=' .   base_url() . 'title/actor/' . $linha->ID_ACTOR . '>' . $linha->NOME . '</a><br> ');
						$cfilmes++;
					}
					if($cfilmes==0)
						$this->table->add_row($nada);
					echo $this->table->generate();
				?>
			</div>
		</div>


		<script>

			var vfilme =[
				<?php	foreach ($votos as $value) {
						echo "{genero:'$value->PONTUACAO', val: $value->NVOTO },";}?>      
		        ];

			$(document).ready(function(){
			    $("#vfilme").dxPieChart({
				    dataSource: vfilme,
				    title: "Votos",
					tooltip: {
						enabled: true,
						
						percentPrecision: 2,
						
					},
					legend: {
						horizontalAlignment: "right",
						verticalAlignment: "top",
						margin: 0
					},
					series: [{
						type: "doughnut",
						argumentField: "genero"
						
					}]
				});


			});

		</script>
		
