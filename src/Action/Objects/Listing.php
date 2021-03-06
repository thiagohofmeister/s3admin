<?php

namespace App\Action\Objects;

use App\Contract\Action;
use App\Response;

/**
 * Recurso responsável por listar arquivos.
 *
 * @author Leonardo Oliveira <leonardo.malia@live.com>
 */
class Listing extends Action\ConnectionRequired
{
    /**
     * @inheritdoc
     */
    public function execute(array $parameters = [])
    {
        $validated = $this->validConnection($parameters);

        if ($validated !== true) {
            return $validated;
        }

        $prefix = trim($this->body['path'], '/') . '/';
        if (empty($this->body['path']) || $this->body['path'] == '/') {
            $prefix = '';
        }

        try {
            $objects = $this->connection->ListObjects([
                'Bucket' => $this->body['bucket'],
                'Delimiter' => '/',
                'Prefix' => $prefix,
                'Marker' => $this->body['marker']
            ]);

        } catch (\Exception $e) {

            return Response\Creator::error($e->getMessage());
        }

        $endFolder = end(explode('/', trim($prefix, '/')));

        $data = [
            'nextMarker' => $objects['NextMarker']
        ];

        $commonPrefixes = $objects->get('CommonPrefixes');

        foreach ($commonPrefixes as $commonPrefix) {

            $name = $this->getName($commonPrefix['Prefix']);

            if ($name == false) {
                continue;
            }

            $data['registers'][] = [
                'name' => $name,
                'type' => 'folder'
            ];
        }

        foreach ($objects['Contents'] as $content) {

            $name = $this->getName($content['Key']);

            if ($name == false) {
                continue;
            }

            if (
                !empty($endFolder)
                &&
                $name == $endFolder
                &&
                $content['Size'] == 0
            ) {
                continue;
            }

            $data['registers'][] = [
                'name' => $name,
                'lastModified' => $content['LastModified']->format('Y-m-d H:i:s'),
                'size' => $content['Size'],
                'type' => 'file'
            ];
        }

        return new Response\Success($data);
    }

    /**
     * @inheritDoc
     */
    public function requiredFields()
    {
        return [
            'path',
            'bucket'
        ];
    }

    /**
     * Retorna o nome do arquivo de acordo com o caminho completo.
     *
     * @param string $string
     *
     * @return string
     */
    private function getName($string)
    {
        $name = end(explode('/', trim($string, '/')));

        if (empty($name)) {
            return false;
        }

        return $name;
    }
}