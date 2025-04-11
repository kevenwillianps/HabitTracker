<?php

/** Defino o local onde a classe esta localizada **/

namespace src\controller\main;

/**
 * Classe responsável por centralizar as funções compartilhadas em outras funções
 *
 * @category  Gestão de Intimação
 * @package   app\src\controller\main
 * @author    Keven
 * @copyright 2025 CDL_DF
 * @license   MIT
 * @version   1.0.0
 * @link https://www.cdldf.souza.inf.br/
 */
class Main
{

    private null|string $string = null;
    private null|string $long = null;

    /**
     * Obtenho as configurações do serviços
     *
     * @return object|false
     */
    public function GetConfig(): object|false
    {

        // Retorno os dados em objeto
        return (object)json_decode(file_get_contents('./config/config.json'));
    }

    public static function GetKey()
    {

        // Busco o config
        $data = (object)json_decode(file_get_contents('./config/config.json'));

        // Retorno os dados em objeto
        return $data->security->key;
    }

    /**
     * Tratamento de antiinjection de string e array
     *
     * @param string|array $string
     * @param string $long
     *
     * @return void
     */
    public function antiInjection($string, string $long = '')
    {

        // Parâmetros de entrada
        $this->string = $string;
        $this->long = $long;

        // Verifico o tipo de entrada
        if (is_array($this->string)) {

            // Retorno o texto sem formatação
            // $this->antiInjectionArray($this->string);

        } elseif (strcmp($this->long, 'S') === 0) {

            // Retorno a string sem tratamento
            return $this->string;
        } else {

            // Remoção de espaçamentos
            $this->string = trim($this->string);

            // Remoção de tags PHP e HTML
            $this->string = strip_tags($this->string);

            // Adição de barras invertidas
            $this->string = addslashes($this->string);

            // Evito ataque XSS
            $this->string = htmlspecialchars($this->string);

            // Elementos de SQL injection
            $elements = array(
                ' drop ',
                ' select ',
                ' delete ',
                ' update ',
                ' insert ',
                ' alert ',
                ' destroy ',
                ' * ',
                ' database ',
                ' drop ',
                ' union ',
                ' TABLE_NAME ',
                ' 1=1 ',
                ' or 1 ',
                ' exec ',
                ' INFORMATION_SCHEMA ',
                ' like ',
                ' COLUMNS ',
                ' into ',
                ' VALUES ',
                ' from ',
                ' undefined '
            );

            // Transformos as palavras em array
            $palavras = explode(' ', str_replace(',', '', $this->string));

            // Percorro todas as palavras localizadas
            foreach ($palavras as $keyPalavra => $palavra) {

                // Percorro todos os elementos do SQL injection
                foreach ($elements as $keyElement => $element) {

                    // Verifico se a palavra deve ser removida
                    if (strcmp(strtolower($palavra), strtolower($element)) === 0) {

                        // Realizo a troca da marcação pela palavra qualificada
                        $this->string = str_replace($palavra, '', $this->string);
                    }
                }
            }

            // Retorno o texto tratado
            return $this->string;
        }
    }

    /**
     * Retorno a hora, minuto e segundo criptografado
     *
     * @return string
     */
    public function RandomHash(): string
    {

        // Retorno da informação
        return md5(rand(1, 1000) . date('H:i:s'));
    }

    /**
     * Retorno apenas a extensão do icone
     *
     * @param string $name
     *
     * @return string
     */
    public function GetExtensionIcon(string $name): string
    {

        // Retorno da informação
        return './assets/images/default/files/' . $name . '.png';
    }

    /**
     * Retorno a extensão do arquivo informado
     *
     * @param string $filename
     *
     * @return string
     */
    public function getFileExtension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    /**
     * Função substituirCaracteresEspeciais
     * Substitui caracteres especiais por seus equivalentes comuns em uma string.
     *
     * @param string $texto - A string original que contém caracteres especiais.
     *
     * @return string - A string modificada com os caracteres especiais substituídos.
     */
    public function RemoveSpecialChars(string $string)
    {

        // Array associativo com os caracteres especiais e seus substitutos
        $caracteresEspeciais = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ã' => 'a',
            'õ' => 'o',
            'ç' => 'c',
            // Adicione outros caracteres especiais e substitutos conforme necessário
        );

        // Substituir os caracteres especiais na string usando str_replace
        // array_keys($caracteresEspeciais) retorna um array com as chaves (caracteres especiais)
        // array_values($caracteresEspeciais) retorna um array com os valores (substitutos)
        $string = str_replace(array_keys($caracteresEspeciais), array_values($caracteresEspeciais), $string);

        // Retornar a string modificada
        return $string;
    }

    /**
     * Função deleteFolder
     * Exclui uma pasta e seus arquivos recursivamente.
     *
     * @param string $folderPath - Caminho da pasta a ser excluída.
     *
     * @return bool
     */
    public function deleteFolder($folderPath): bool
    {

        // Verifica se a pasta existe
        if (is_dir($folderPath)) {

            // Abre o diretório
            $directory = opendir($folderPath);

            // Loop para excluir cada arquivo dentro da pasta
            while (($file = readdir($directory)) !== false) {

                // Ignora os diretórios pai e atual
                if ($file != '.' && $file != '..') {

                    $filePath = $folderPath . '/' . $file;

                    // Se for um diretório, chama recursivamente a função para excluir seus arquivos
                    if (is_dir($filePath)) {

                        $this->deleteFolder($filePath);
                    } else {

                        // Exclui o arquivo
                        unlink($filePath);
                    }
                }
            }

            // Fecha o diretório
            closedir($directory);

            // Exclui a pasta
            rmdir($folderPath);

            return true;
        } else {

            return false;
        }
    }

    /**
     * Função para formatar o tamanho do arquivo em uma unidade compreensível.
     *
     * Esta função recebe o tamanho do arquivo em bytes e o converte para uma unidade
     * de medida mais adequada, como kilobytes (KB), megabytes (MB), gigabytes (GB), etc.
     *
     * @param int $size Tamanho do arquivo em bytes.
     * @return string Tamanho formatado com duas casas decimais e a unidade correspondente.
     */
    public function formatFileSize($size)
    {

        // Array de unidades de medida
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        // Loop para dividir o tamanho por 1024 até que seja menor que 1024
        for ($i = 0; $size > 1024; $i++) {

            $size /= 1024;
        }

        // Retorna o tamanho formatado com duas casas decimais e a unidade correspondente
        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Removo a extensão da string
     *
     * @param string $nomeArquivo
     *
     * @return void
     */
    public function RemoveExtension(string $nomeArquivo): string
    {
        return pathinfo($nomeArquivo, PATHINFO_FILENAME);
    }

    /**
     * Converto dados que estão em objetos para arquivo XML
     *
     * @param string $json
     * @param string $rootElement
     * @param string|null $filePath
     *
     * @return string
     */
    public function jsonToXmlFormatted(string $json, string $rootElement, null|string $filePath): string
    {
        // Decodificar o JSON fornecido em um array associativo.
        $array = json_decode($json, true);

        // Verificar se houve erro ao decodificar o JSON.
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
        }

        // Criar um novo documento XML utilizando a classe DOMDocument.
        $dom = new \DOMDocument('1.0', 'UTF-8');

        // Configurar a saída do XML para que seja formatada (com identação e quebras de linha).
        $dom->formatOutput = true;

        // Criar o elemento raiz com o nome fornecido em $rootElement.
        $root = $dom->createElement($rootElement);

        // Adicionar o elemento raiz ao documento.
        $dom->appendChild($root);

        // Função anônima recursiva para adicionar os elementos do array ao XML.
        $addArrayToXml = function ($array, \DOMElement $xmlElement, \DOMDocument $dom) use (&$addArrayToXml) {
            // Iterar por cada item no array.
            foreach ($array as $key => $value) {
                // Determinar o nome da tag. Usa 'TAG_NAME' se presente, senão a chave ou 'ITEM' para índices numéricos.
                $tagName = isset($value['TAG_NAME']) ? $value['TAG_NAME'] : (is_numeric($key) ? "ITEM" : $key);

                // Remover a propriedade 'TAG_NAME' do array para evitar adicioná-la como elemento.
                if (is_array($value)) {
                    unset($value['TAG_NAME']);
                }

                // Se o valor for um array ou objeto, criar um elemento e chamar a função recursivamente.
                if (is_array($value) || is_object($value)) {
                    // Criar um novo elemento com o nome determinado.
                    $child = $dom->createElement($tagName);

                    // Adicionar o elemento filho ao elemento XML atual.
                    $xmlElement->appendChild($child);

                    // Chamar a função recursivamente para processar os elementos internos.
                    $addArrayToXml($value, $child, $dom);
                } else {
                    // Se o valor for um tipo escalar (string, número, etc.), criar um elemento e adicionar o valor.
                    $child = $dom->createElement($tagName);

                    // Adicionar o conteúdo ao elemento: CDATA para strings, texto vazio para null ou texto simples.
                    if (is_string($value) && !empty($value)) {
                        // Adicionar o valor como uma seção CDATA para proteger caracteres especiais.
                        $cdata = $dom->createCDATASection($value);
                        $child->appendChild($cdata);
                    } elseif (is_null($value)) {
                        // Adicionar texto vazio se o valor for null.
                        $child->appendChild($dom->createTextNode(''));
                    } else {
                        // Adicionar o valor como texto simples.
                        $child->appendChild($dom->createTextNode($value));
                    }

                    // Adicionar o elemento filho ao elemento XML atual.
                    $xmlElement->appendChild($child);
                }
            }
        };

        // Iniciar a conversão do array para XML a partir do elemento raiz.
        $addArrayToXml($array, $root, $dom);

        // Se um caminho de arquivo foi fornecido, salvar o XML no disco.
        if ($filePath) {
            $dom->save($filePath);
        }

        // Retornar o XML gerado como uma string.
        return $dom->saveXML();
    }

    /**
     * Converto uma string base64 para o arquivo
     *
     * @param string $base64String
     * @param string $outputDir
     * @param string $filenameWithoutExtension
     *
     * @return void
     */
    public function saveBase64ToFile(string $base64String, string $outputDir, string $filenameWithoutExtension)
    {
        // Separar a parte do cabeçalho e os dados
        list($type, $data) = explode(';', $base64String);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        // Obter a extensão do arquivo a partir do cabeçalho
        $mime = explode(':', $type)[1];
        $extension = '';

        // Validar e formatar a extensão
        switch ($mime) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
            case 'application/pdf':
                $extension = 'pdf';
                break;
            case 'application/msword':
                $extension = 'doc';
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $extension = 'docx';
                break;
            case 'text/xml':
                $extension = 'xml';
                break;
            default:
                throw new \Exception("Tipo MIME não suportado: $mime");
        }

        // Verificar e criar a pasta se não existir
        if (!is_dir($outputDir)) {
            if (!mkdir($outputDir, 0777, true)) {
                throw new \Exception("Falha ao criar a pasta: $outputDir");
            }
        }

        // Nome completo do arquivo
        $fullFilename = $outputDir . '/' . $filenameWithoutExtension . '.' . $extension;

        // Excluir o arquivo se já existir
        if (file_exists($fullFilename)) {
            if (!unlink($fullFilename)) {
                throw new \Exception("Falha ao excluir o arquivo existente: $fullFilename");
            }
        }

        // Salvar o arquivo
        if (file_put_contents($fullFilename, $data)) {
            return $fullFilename;
        } else {
            throw new \Exception("Falha ao salvar o arquivo.");
        }
    }

    /**
     * Função para remover a máscara de CPF ou CNPJ.
     *
     * @param string $document Documento com máscara (CPF ou CNPJ).
     * @return string Documento sem máscara.
     */
    public function removeMascaraCpfCnpj(string $document): string
    {
        // Remove todos os caracteres que não são números
        return preg_replace('/\D/', '', $document);
    }

    /**
     * Verifico se devo validar o CPF ou CNPJ
     *
     * @param string $value
     *
     * @return boolean|string
     */
    public function validarCpfCnpj(string $value): bool|string
    {
        // Remove todos os caracteres que não sejam dígitos.
        $value = preg_replace('/[^0-9]/', '', $value);

        // Verifica se o número de dígitos corresponde a um CPF (11 dígitos) ou CNPJ (14 dígitos).
        if (strlen($value) === 11) {
            // Se o valor tem 11 dígitos, chama a função de validação de CPF.
            return $this->validarCpf($value);
        } elseif (strlen($value) === 14) {
            // Se o valor tem 14 dígitos, chama a função de validação de CNPJ.
            return $this->validarCnpj($value);
        } else {
            // Retorna falso se o número de dígitos não for 11 ou 14.
            return false;
        }
    }

    /**
     * Validação do CPF
     *
     * @param string $cpf
     *
     * @return boolean
     */
    private function validarCpf(string $cpf): bool
    {
        // Verifica se todos os dígitos do CPF são iguais (ex: 111.111.111-11), o que é inválido.
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Loop para calcular os dois dígitos verificadores do CPF.
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            // Calcula o somatório do CPF multiplicando os números pelo peso decrescente.
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            // Calcula o dígito verificador com base no somatório.
            $d = ((10 * $d) % 11) % 10;
            // Verifica se o dígito calculado é igual ao dígito do CPF. Se não for, CPF é inválido.
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        // Retorna verdadeiro se os dois dígitos verificadores estiverem corretos.
        return true;
    }

    /**
     * Validação do CNPJ
     *
     * @param string $cnpj
     *
     * @return boolean
     */
    private function validarCnpj(string $cnpj): bool
    {
        // Verifica se todos os dígitos do CNPJ são iguais (ex: 11.111.111/1111-11), o que é inválido.
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Arrays de peso para os cálculos dos dígitos verificadores do CNPJ.
        $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        // Loop para calcular os dois dígitos verificadores do CNPJ.
        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            // Seleciona o array de peso correto para o cálculo.
            $peso = ($t === 12) ? $peso1 : $peso2;
            // Calcula o somatório do CNPJ multiplicando os números pelo peso correspondente.
            for ($c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $peso[$c];
            }
            // Calcula o dígito verificador com base no somatório.
            $d = ((10 * $d) % 11) % 10;
            // Verifica se o dígito calculado é igual ao dígito do CNPJ. Se não for, CNPJ é inválido.
            if ($cnpj[$c] != $d) {
                return false;
            }
        }

        // Retorna verdadeiro se os dois dígitos verificadores estiverem corretos.
        return true;
    }

    /**
     * Função para remover a máscara de um CEP.
     *
     * @param string $cep CEP com máscara.
     * @return string CEP sem máscara.
     */
    public function removerMascaraCep(string $cep): string
    {
        // Remove qualquer caractere que não seja número
        return preg_replace('/\D/', '', $cep);
    }

    /**
     * Função para validar um CEP.
     *
     * @param string $cep CEP a ser validado.
     * @return bool Retorna true se o CEP for válido, caso contrário false.
     */
    public function validarCep(string $cep): bool
    {
        // Remove qualquer máscara do CEP
        $cep = preg_replace('/\D/', '', $cep);

        // Verifica se o CEP tem exatamente 8 dígitos
        return preg_match('/^\d{8}$/', $cep) === 1;
    }

    /**
     * Função para remover a máscara de um telefone.
     *
     * @param string $telefone Telefone com máscara.
     * @return string Telefone sem máscara.
     */
    public function removerMascaraTelefone(string $telefone): string
    {
        // Remove qualquer caractere que não seja número
        return preg_replace('/\D/', '', $telefone);
    }

    /**
     * Função para validar um número de telefone.
     * O telefone deve ter entre 10 e 11 dígitos, considerando códigos de área e números com 9 dígitos.
     *
     * @param string $telefone Telefone sem máscara.
     * @return bool Retorna true se o telefone for válido, caso contrário, false.
     */
    public function validarTelefone(string $telefone): bool
    {
        // Remove qualquer caractere que não seja número
        $telefone = $this->removerMascaraTelefone($telefone);

        // Verifica se o telefone tem 8 ou 10 dígitos
        return preg_match('/^\d{8,9}$/', $telefone) === 1;
    }

    /**
     * Função para validar um endereço de e-mail.
     *
     * @param string $email Endereço de e-mail a ser validado.
     * @return bool Retorna true se o e-mail for válido, caso contrário, false.
     */
    public function validarEmail(string $email): bool
    {
        // Usa a função filter_var para validar o e-mail
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function formatarTexto(string $texto): string
    {
        // Remove acentos e caracteres especiais
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = preg_replace('/[^A-Za-z0-9 ]/', '', $texto); // Remove caracteres não alfanuméricos, exceto espaço

        // Converte para maiúsculas
        $texto = strtoupper($texto);

        // Substitui espaços por underline
        $texto = str_replace(' ', '_', $texto);

        return $texto;
    }

    /**
     * Formato o valor para os padrões utilizado no banco de dados
     *
     * @param string $valor
     *
     * @return string
     */
    public static function FormataValorDB(string $valor): string
    {

        // Remove separadores de milhar e substitui vírgula por ponto
        $valorFormatado = str_replace(['.', ','], ['', '.'], $valor);

        // Garante que o valor seja numérico e formatado corretamente para MySQL
        $valorFinal = number_format((float) $valorFormatado, 2, '.', '');

        // Retorno da informação
        return $valorFinal;
    }

    public static function getInitials($fullName)
    {
        // Remove espaços extras
        $fullName = trim($fullName);

        // Divide o nome em partes
        $nameParts = explode(' ', preg_replace('/\s+/', ' ', $fullName));

        // Se houver pelo menos dois nomes
        if (count($nameParts) > 1) {
            $firstInitial = strtoupper($nameParts[0][0]); // Primeira letra do primeiro nome
            $secondInitial = strtoupper($nameParts[1][0]); // Primeira letra do segundo nome

            return $firstInitial . $secondInitial;
        }

        return '';
    }

    public static function GetFile($path)
    {
        // Retorno os dados em objeto
        return file_get_contents($path);
    }

    public static function HandlingErrors(array $errors)
    {

        // Declaração de Variaveis
        $info = null;

        /** Verifico se deve informar os erros */
        if (count($errors)) {

            /** Verifica a quantidade de erros para informar a legenda */
            $info = count($errors) > 1 ? '<center>Os seguintes erros foram encontrados</center>' : '<center>O seguinte erro foi encontrado</center>';

            /** Lista os erros  */
            foreach ($errors as $keyError => $error) {

                /** Monto a mensagem de erro */
                $info .= '</br>' . ($keyError + 1) . ' - ' . $error;
            }

            /** Retorno os erros encontrados */
            return (string) $info;
        } else {

            return false;
        }
    }

    /**
     * Retorna o nome do mês de acordo com o numero informado
     *
     * @param integer $data
     *
     * @return string
     */
    public static function GetMonth(int $data): string
    {

        // Lista do meses existentes
        $month = [

            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'

        ];

        // Decremento a informação para seguir a ordem da array
        $data--;

        // Retorno da informação
        return $month[$data];
    }

    /**
     * Retorna uma cor de acordo com o indice informado
     *
     * @param integer $data
     *
     * @return string
     */
    public static function GetColorChart(int $data): string
    {

        // Lista de cores existentes
        $colors = [

            '#3454d1',
            '#1565c0',
            '#1976d2',
            '#1e88e5',
            '#2196f3',
            '#42a5f5',
            '#64b5f6',
            '#90caf9',
            '#aad6fa'

        ];

        // Retorno da informação
        return $colors[$data];
    }
}
