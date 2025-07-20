<?php

/**
 * Popup Modal para Criar Endereço
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

?>

<div id="create-endereco-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
        <h2 class="text-2xl font-bold mb-4">Criar Novo Endereço</h2>
        <form id="create-endereco-form" method="post" class="space-y-4">
            <div>
                <label for="endereco-cep" class="block text-sm font-medium text-gray-700">CEP</label>
                <input type="text" id="endereco-cep" name="cep" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="8">
            </div>
            <div>
                <label for="endereco-endr" class="block text-sm font-medium text-gray-700">Endereço</label>
                <input type="text" id="endereco-endr" name="endereco" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="endereco-numero" class="block text-sm font-medium text-gray-700">Número</label>
                <input type="text" id="endereco-numero" name="numero" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" maxlength="5">
            </div>
            <div>
                <label for="endereco-complemento" class="block text-sm font-medium text-gray-700">Complemento</label>
                <input type="text" id="endereco-complemento" name="complemento" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none">Criar Endereço</button>
            </div>
        </form>
        <button id="close-endereco-modal" class="absolute top-0 right-0 m-4 text-black">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>