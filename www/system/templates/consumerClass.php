<?php

class ConsumerClass
{
    public $data;

    public function __construct(string $type ) {
        $file = __DIR__ ."/template_". $type .".yaml";
        $result = false;
        if ( file_exists( $file ) ) {
            $result = yaml_parse_file($file);
        }
        if ($result === false) {
            # throw new Exception("No such a consumer type '".$type."'. (file ".$file." not exists)");
            $result = [
                "params" => [],
                "events" => [],
            ];
        }
        $this->type = $type;
        $this->data = $result;
    }
    public function getEvents(): array {
        return $this->data['events'];
    }

    public function getEventParams(string $evt): array {
        return $this->data['events'][$evt];
    }

    public function getParams(): array {
        return $this->data['params'];
    }

}
?>