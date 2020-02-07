	
		<!-- Modal -->
		<?php $url = $urlstart.'/'.$urlid.'/'.$urlend ?>
		<div class="modal fade" id="{{ $href }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title text-danger" id="exampleModalLabel">BELANGRIJK</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">
		      Als je met deze bewerking verdergaat, dan verander je grondig de databank.
			  Je mag dit dus maar uitvoeren als je 200% zeker bent
		      </div>
			  <!-- div>{{ $url }}</div -->
			  <div>{{ $url }}</div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Niet doen</button>
		        <a href="{{ $url }}">
				<button type="submit" class="btn btn-primary">Voer toch uit</button>
				</a>
		      </div>
		    </div>
		  </div>
		</div>	