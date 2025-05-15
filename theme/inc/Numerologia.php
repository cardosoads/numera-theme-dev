<?php

require_once 'NumerologiaDados.php'; // Certifique-se de ajustar o caminho conforme necessário
require_once 'NumerologiaCalculos.php'; // Certifique-se de ajustar o caminho conforme necessário

class Numerologia
{
    private $alfabeto;
    private $vogais;
    private $consoantes;
    private $tabelaPiramides;
    private $cores;
    private $profissoes;
    private $tabelaNumerosFavoraveis;
    private $numerosHarmonicos;
    private $meses;
    private $anjos;
    private $vibracoes;
    private $sequenciasVibracionais;

    public function __construct()
    {
        $this->alfabeto = NumerologiaDados::obterAlfabeto();
        $this->vogais = NumerologiaDados::obterVogais();
        $this->consoantes = NumerologiaDados::obterConsoantes();
        $this->tabelaPiramides = NumerologiaDados::obterTabelaPiramides();
        $this->cores = NumerologiaDados::obterCores();
        $this->profissoes = NumerologiaDados::obterProfissoes();
        $this->tabelaNumerosFavoraveis = NumerologiaDados::obterTabelaNumerosFavoraveis();
        $this->meses = NumerologiaDados::obterMeses();
        $this->numerosHarmonicos = NumerologiaDados::obterNumerosHarmoncos();
        $this->anjos = NumerologiaDados::obterAnjos();
        $this->vibracoes = NumerologiaDados::obterVibracoesResidencia();
        $this->sequenciasVibracionais = NumerologiaDados::sequenciasVibracionais();
    }

    public function converterNomeRua($nomeRua)
    {
        return NumerologiaCalculos::converterNomeRua($nomeRua, $this->alfabeto);
    }

    public function calcularEndereco($numeroCasa, $nomeRua, $numeroApto = null)
    {
        return NumerologiaCalculos::calcularEndereco($numeroCasa, $nomeRua, $this->alfabeto, $numeroApto);
    }

    public function calcularNumeroCasa($numeroCasa)
    {
        return NumerologiaCalculos::calcularNumeroCasa($numeroCasa);
    }

    public function calcularPlaca($placa)
    {
        return NumerologiaCalculos::calcularPlaca($placa, $this->alfabeto);
    }
    
    public function calcularTelefone($telefone)
    {
        return NumerologiaCalculos::calcularTelefone($telefone);
    }

    public function calcularAnoPessoal($dataNascimento)
    {
        return NumerologiaCalculos::calcularAnoPessoal($dataNascimento);
    }

    public function mesPessoalCalc($dataNascimento)
    {
        $anoPessoal = $this->calcularAnoPessoal($dataNascimento);
        return NumerologiaCalculos::mesPessoalCalc($anoPessoal);
    }

    public function calcularDiaPessoal($dataNascimento)
    {
        $mesPessoal = $this->mesPessoalCalc($dataNascimento);
        return NumerologiaCalculos::calcularDiaPessoal($mesPessoal);
    }

    public function calcularNumeroDestino($dataNascimento)
    {
        // Chama o método da classe NumerologiaCalculos
        return NumerologiaCalculos::calcularNumeroDestino($dataNascimento);
    }

    public function calcularLicoesCarmicas($nome)
    {
        return NumerologiaCalculos::calcularLicoesCarmicas($nome, $this->alfabeto);
    }

    public function numerosHarmonicos($dataNascimento)
    {
        return NumerologiaCalculos::numerosHarmonicos($dataNascimento, $this->numerosHarmonicos);
    }

    public function calcularCiclos($dataNascimento, $licoesCarmicas)
    {
        return NumerologiaCalculos::calcularCiclos($dataNascimento, $licoesCarmicas, $this->alfabeto);
    }

    public function separarNomeCompleto($nomeCompleto){
        return NumerologiaCalculos::separarNomeCompleto($nomeCompleto);
    }

    public function obterDiasFavoraveis($dataNascimento)
    {
        return NumerologiaCalculos::obterDiasFavoraveis($dataNascimento, $this->tabelaNumerosFavoraveis, $this->meses);
    }

    public function grauAscensao($nome)
    {
        return NumerologiaCalculos::grauAscensao($nome);
    }

    public function calcularNumeroImpressao($nome)
    {
        return NumerologiaCalculos::calcularNumeroImpressao($nome, $this->consoantes);
    }

    public function calcularNumeroExpressao($nome)
    {
        return NumerologiaCalculos::calcularNumeroExpressao($nome, $this->alfabeto);
    }

    public function calcularNumeroMotivacao($nome)
    {
        return NumerologiaCalculos::calcularNumeroMotivacao($nome, $this->vogais);
    }

    public function calcularNumeroMissao($numeroDestino, $numeroExpressao)
    {
        return NumerologiaCalculos::calcularNumeroMissao($numeroDestino, $numeroExpressao);
    }

    public function calcularTendenciaOculta($nome)
    {
        return NumerologiaCalculos::calcularTendenciaOculta($nome, $this->alfabeto);
    }

    public function calcularNumeroPsiquico($diaNascimento)
    {
        return NumerologiaCalculos::calcularNumeroPsiquico($diaNascimento);
    }

    public function talentoOculto($motivacao, $numeroDeExpressao)
    {
        return NumerologiaCalculos::talentoOculto($motivacao, $numeroDeExpressao);
    }

    public function momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo)
    {
        return NumerologiaCalculos::momentosDecisivos($dataNascimento, $dataFimPrimeiroCiclo);
    }

    public function coresFavoraveis($nomeCompleto)
    {
        return NumerologiaCalculos::coresFavoraveis($nomeCompleto, $this->alfabeto, $this->cores);
    }

    public function calculoDividasCarmicas($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calculoDividasCarmicas($nomeCompleto, $dataNascimento, $this->alfabeto);
    }

    public function calcularNumeroAmor($numero_destino, $numero_expressao)
    {
        return NumerologiaCalculos::calcularNumeroAmor($numero_destino, $numero_expressao, NumerologiaDados::obterTabelaHarmoniaConjugal());
    }

    public function relacoesIntervalores($nomeCompleto)
    {
        return NumerologiaCalculos::relacoesIntervalores($nomeCompleto, $this->alfabeto);
    }

    public function calcularArcanos($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanos($nomeCompleto, $dataNascimento, $this->alfabeto);
    }
    public function getArcanoAtual($arcano)
    {
        return NumerologiaCalculos::getArcanoAtual($arcano);
    }
    public function calcularArcanoVida($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoVida($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }
    public function calcularArcanoPessoal($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoPessoal($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularArcanoSocial($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoSocial($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularArcanoDestino($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoDestino($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularPiramdeDestino($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularPiramideDestino($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularPiramdePessoal($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularPiramidePessoal($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularPiramdeSocial($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularPiramideSocial($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularPiramdeVida($nomeCompleto)
    {
        return NumerologiaCalculos::calcularPiramideVida($nomeCompleto, $this->alfabeto);
    }

    public function sequenciasEncontradas($sequencia)
    {
        return NumerologiaCalculos::sequenciasEncontradas($sequencia, $this->sequenciasVibracionais);
    }

    public function sequenciaVibracional($piramide)
    {
        return NumerologiaCalculos::sequenciaVibracional($piramide);
    }

    public function calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoPiramideDestino($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoPiramidePessoal($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento)
    {
        return NumerologiaCalculos::calcularArcanoPiramideSocial($nomeCompleto, $dataNascimento, $this->tabelaPiramides);
    }

    public function carcularDesafios($dataNascimento)
    {
        return NumerologiaCalculos::calcularDesafios($dataNascimento);
    }

    public function calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento)
    {
        return NumerologiaCalculos::calcularTesteVocacional($numeroDestino, $numeroMissao, $numeroExpressao, $dataNascimento, $this->profissoes);
    }

    public function calcularRespostaSubconsciente($nome)
    {
        return NumerologiaCalculos::calcularRespostaSubconsciente($nome, $this->alfabeto);
    }

    public function buscaAnjo($dataNascimento)
    {
        return NumerologiaCalculos::buscaAnjo($dataNascimento, $this->anjos);
    }

    public function fasesLua($data_str)
    {
        return NumerologiaCalculos::faseLua($data_str);
    }
}
