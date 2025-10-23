<?php
// Configurações básicas e headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// --- Configuração da API e Cache ---
// Usaremos a API pública do AwesomeAPI (sem necessidade de chave) para cotações básicas
const API_URL = 'https://economia.awesomeapi.com.br/json/last/USD-BRL,EUR-BRL,BTC-BRL';
const CACHE_DIR = __DIR__ . '/cache/';
const CACHE_FILE = CACHE_DIR . 'currency_cache.json';
const CACHE_DURATION_SECONDS = 300; // 5 minutos (5 * 60)

/**
 * Tenta carregar dados do cache, se existir e for válido.
 * @return array|null Dados em cache ou null se inválido/inexistente.
 */
function getCachedData() {
    if (!file_exists(CACHE_FILE)) {
        return null;
    }

    $fileTime = filemtime(CACHE_FILE);
    $isCacheValid = (time() - $fileTime) < CACHE_DURATION_SECONDS;

    if ($isCacheValid) {
        $data = file_get_contents(CACHE_FILE);
        $cachedData = json_decode($data, true);
        
        if ($cachedData) {
            $cachedData['source'] = 'Cache';
            $cachedData['cached_at'] = date('Y-m-d H:i:s', $fileTime);
            return $cachedData;
        }
    }
    
    // Se o cache expirou ou falhou a leitura
    return null;
}

/**
 * Salva os dados obtidos da API externa no cache.
 * @param array $data Os dados a serem cacheados.
 */
function saveCacheData($data) {
    if (!is_dir(CACHE_DIR)) {
        // Cria a pasta com permissão de escrita, se não existir
        mkdir(CACHE_DIR, 0777, true); 
    }
    
    // Remove os campos de metadata antes de salvar, para manter o cache "limpo"
    unset($data['source'], $data['cached_at']);
    
    file_put_contents(CACHE_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

/**
 * Busca dados da API externa.
 * @return array Os dados da API.
 */
function fetchExternalData() {
    // NOTA: Em produção, você usaria cURL ou uma biblioteca HTTP para mais controle
    $apiResponse = file_get_contents(API_URL);

    if ($apiResponse === false) {
        throw new Exception("Falha ao se conectar com a API externa de cotações.");
    }

    $data = json_decode($apiResponse, true);
    
    if (!$data) {
        throw new Exception("Resposta inválida da API externa.");
    }
    
    // Adiciona metadata
    $data['source'] = 'API Externa';
    $data['cached_at'] = date('Y-m-d H:i:s');
    
    return $data;
}


// --- Lógica Principal da API ---

$method = $_SERVER['REQUEST_METHOD'] ?? '';

if ($method === 'GET') {
    $result = ['success' => false, 'data' => null, 'error' => ''];

    try {
        // 1. Tenta obter dados do cache
        $data = getCachedData();
        
        // 2. Se não houver dados válidos no cache, busca na API externa
        if ($data === null) {
            $data = fetchExternalData();
            // 3. Salva os novos dados no cache para futuras requisições
            saveCacheData($data);
        }
        
        $result['success'] = true;
        $result['data'] = $data;

    } catch (Exception $e) {
        http_response_code(500);
        $result['error'] = $e->getMessage();
    }

    echo json_encode($result);
    
} elseif ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método não permitido.']);
}
?>
