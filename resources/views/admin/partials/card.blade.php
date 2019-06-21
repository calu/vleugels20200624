<div class="card">
	<div class="card-header">
		<i class="fa {{ $icon }}"></i>
		{{ $header }}
		<getal-cirkel aantal="{{ $aantal }}">{{ $aantal }}</getal-cirkel>
	</div>
	<div class="card-body">
		<div class="card-text">
			{{ $text }}
		</div>
		<a href="{{ $href }}" class="btn btn-outline-primary">{{ $button }}</a>
	</div>
</div>