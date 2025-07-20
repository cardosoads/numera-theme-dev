<?php

/**
 * Popup Modal para Criar Mapa
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

?>

<div id="create-map-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
	<div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
		<h2 class="text-2xl font-bold mb-4">Criar Novo Mapa</h2>
		<form id="create-map-form" method="POST" class="space-y-4">
			<div>
				<label for="map-title" class="block text-sm font-medium text-gray-700">Título do Mapa</label>
				<input type="text" id="map-title" name="title" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
			</div>
			<!-- <div>
				<label class="block text-sm font-medium text-gray-700">Tipo de Mapa</label>
				<div class="mt-1 flex items-center">
					<input type="radio" name="type" value="mapas" checked class="mr-2">
					<span>Mapa</span>
				</div>
			</div> -->
			<div id="map-fields">
				<div>
					<label for="map-name" class="block text-sm font-medium text-gray-700">Nome Completo</label>
					<input type="text" id="map-name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
				</div>
				<div>
					<label for="map-dob" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
					<input type="date" id="map-dob" name="dob" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
				</div>
			</div>
			<div>
				<button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Criar Mapa</button>
			</div>
		</form>
		<button id="close-map-modal" class="absolute top-0 right-0 m-4 text-black">
			<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
			</svg>
		</button>
	</div>
</div>