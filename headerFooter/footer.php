
	<footer class="container-fluid">
					<div class="row">
					<!--<div class="col-md-3 col-sm-3 col-xs-12 link_i"><a class="btn btn-primary" target="_blank" href="http://www.facebook.com/kmermarket"><img src="../img/facebook.png" alt="Rejoignez nous sur facebook"/></a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link_i"><a class="btn btn-info" target="_blank" href="http://twitter.com/KmerMarket"><img src="../img/twitter.png" alt="Rejoignez nous sur Twitter"/></a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link_i"><a class="btn btn-danger" target="_blank" href="https://www.youtube.com/watch?v=HGoRsu-kzqU&list=PL2vXImSdkJQjpAO61qXRNgFdh35WGXvTB"><img src="../img/youtube.png" alt="Rejoignez nous sur youtube"/></a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link_i"><a class="btn btn-success" target="_blank" href="https://www.kmermarket.com/docs/use_kmermarket.pdf"><img src="../img/aide.png" alt="Comment utiliser KmerMarket"/></a></div>
						Instagram est pour plus tard -->
						
						<!-- OLD VERSION Instagram est pour plus tard -->
						<div class="col-md-3 col-sm-3 col-xs-12 link"><a class="btn btn-primary" target="_blank" href="http://www.facebook.com/kmermarket">Rejoignez nous sur Facebook</a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link"><a class="btn btn-info" target="_blank" href="http://twitter.com/KmerMarket">Rejoignez nous sur Twitter</a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link"><a class="btn btn-danger" target="_blank" href="https://www.youtube.com/watch?v=HGoRsu-kzqU&list=PL2vXImSdkJQjpAO61qXRNgFdh35WGXvTB">Rejoignez nous sur Youtube</a></div>
						<div class="col-md-3 col-sm-3 col-xs-12 link"><a class="btn btn-success" target="_blank" href="https://www.kmermarket.com/docs/use_kmermarket.pdf">Comment utiliser KmerMarket</a></div>
						
						
						<!--pour les petites tailles-->
						<?php
						if($_SESSION["index"] =="true")
						{
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="http://www.facebook.com/kmermarket"><img src="img/facebook.png" alt="Rejoignez nous sur facebook"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3  link_i"><a class="notDisplayed" target="_blank" href="http://twitter.com/KmerMarket"><img src="img/twitter.png" alt="Rejoignez nous sur Twitter"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3  link_i"><a class="notDisplayed" target="_blank" href="https://www.youtube.com/watch?v=HGoRsu-kzqU&list=PL2vXImSdkJQjpAO61qXRNgFdh35WGXvTB" ><img src="img/youtube.png" alt="Rejoignez nous sur youtube"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="localhost/docs/use_kmermarket.pdf" ><img src="img/aide.png" alt="Comment utiliser Localhost"/></a></div>');
						}
						else /*if(($_SESSION["annonces"]="active" && $_SESSION["index"] =="false")||
								$_SESSION["mesAnnonces"]="active" ||
								$_SESSION["compte"]="active")*/
						{
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="http://www.facebook.com/kmermarket"><img src="../img/facebook.png" alt="Rejoignez nous sur facebook"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="http://twitter.com/KmerMarket"><img src="../img/twitter.png" alt="Rejoignez nous sur Twitter"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="https://www.youtube.com/watch?v=HGoRsu-kzqU&list=PL2vXImSdkJQjpAO61qXRNgFdh35WGXvTB" ><img src="../img/youtube.png" alt="Rejoignez nous sur youtube"/></a></div>');
							echo('<div class="col-md-3 col-sm-3 col-xs-3 link_i"><a class="notDisplayed" target="_blank" href="localhost/docs/use_kmermarket.pdf" ><img src="../img/aide.png" alt="Comment utiliser Localhost"/></a></div>');
						}																									
						
						?>
						
					</div>
					<br/>
					<div class="row">
						<div class="col-md-12">
							<p class="texte_footer">
								@Copyrights KmerMarket - 2020 
								built and designed by 
								<a target="_blank" href="http://www.noumisomen.com" >
									Noumi Franc
								</a>
							</p>
						</div>
					</div>
	</footer>
