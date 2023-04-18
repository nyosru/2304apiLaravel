<?php

namespace App\Services;

use Illuminate\Http\Request;

// получить слова с апи https://www.oxfordlearnersdictionaries.com/ используя запрос http laravel ключ 6da9adfd84b6b43a9024d0d58856373e и  app id 1e0f6373

class DictonariesOxfordService
{
    // И ключ 6da9adfd84b6b43a9024d0d58856373e
    // app_id = 1e0f6373
    private static $app_id = '1e0f6373';
    private static $key = '6da9adfd84b6b43a9024d0d58856373e';

    // функция сервиса апи oxforddictionaries.com для перевода слова с английского на испанский 

    public static function translate($word, $from = 'en', $to = 'ru')
    {

        $return = [];

        // $url = "https://od-api.oxforddictionaries.com/api/v2/translations/en/es/" . $word;
        // $url = "https://od-api.oxforddictionaries.com/api/v2/translations/en/es/" . $word;
        // $url = "https://od-api.oxforddictionaries.com/api/v2/translations/en/ru/" . $word;
        $return['url'] =
            $url = 'https://od-api.oxforddictionaries.com/api/v2/translations/' . $from . '/' . $to . '/' . $word;
        $return['header'] =
            $headers = [
                'app_id:' . self::$app_id,
                'app_key:' . self::$key
            ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        // Проверяем наличие ошибок
        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            // echo 'Прошло ', $info['total_time'], ' секунд во время запроса к ', $info['url'], "\n";
        }

        curl_close($ch);

        if ($info['http_code'] == 429) {
            // return ['error' => true, 'code' => $info['http_code'], 'message' => 'Too Many Requests'];
            throw new \Exception('Too Many Requests', $info['http_code']);
        }

        // return [$return, $info, json_decode($response)];
        $re = json_decode($response);
        $re['info'] = $info;
        return $re;

        $result = json_decode($response);
        $translated_words = $result->results[0]->lexicalEntries[0]->entries[0]->senses[0]->translations[0]->text;

        return $translated_words;
    }

    public static function getWorld($word_id)
    {

        // Установка параметров запроса
        // $app_id = 'ваш_app_id';
        $app_id = self::$app_id;
        // $app_key = 'ваш_app_key';
        $app_key = self::$key;
        $lang = 'en';
        // $word_id = 'example';

        $endpoint = "https://od-api.oxforddictionaries.com:443/api/v2/entries/$lang/$word_id";

        // Выполнение GET-запроса к API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('app_id: ' . $app_id, 'app_key: ' . $app_key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        // Разбор ответа и получение списка слов
        $response = json_decode($output, true);
        $words = array();

        if (!empty($response['results']))
            foreach ($response['results'] as $result) {
                foreach ($result['lexicalEntries'] as $entry) {
                    foreach ($entry['entries'] as $subentry) {
                        foreach ($subentry['senses'] as $sense) {
                            foreach ($sense['definitions'] as $definition) {
                                preg_match_all("/\w+/", $definition, $matches);
                                foreach ($matches[0] as $match) {
                                    $words[] = strtolower($match);
                                }
                            }
                        }
                    }
                }
            }

        // Вывод списка слов
        // echo implode(', ', $words);
        return implode(', ', $words);
    }
}
