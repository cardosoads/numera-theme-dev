<?php

/**
 * Popup Modal para Criar Endereço
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

?>

<div id="create-empresa-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
        <h2 class="text-2xl font-bold mb-4">Criar Nova Empresa</h2>
        <form id="create-empresa-form" method="post" class="space-y-4">
            <div>
                <label for="empresa-razao-social" class="block text-sm font-medium text-gray-700">Razão Social</label>
                <input type="text" id="empresa-razao-social" name="razao_social" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="empresa-nome-fantasia" class="block text-sm font-medium text-gray-700">Nome fantasia</label>
                <input type="text" id="empresa-nome-fantasia" name="nome_fantasia" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="empresa-data-abertura" class="block text-sm font-medium text-gray-700">Data de abertura</label>
                <input type="date" id="empresa-data-abertura" name="data_abertura" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="empresa-data-alteracao" class="block text-sm font-medium text-gray-700">Data de alteração (se houver)</label>
                <input type="date" id="empresa-data-alteracao" name="data_alteracao" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none">Criar Empresa</button>
            </div>
        </form>
        <button id="close-empresa-modal" class="absolute top-0 right-0 m-4 text-black">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>