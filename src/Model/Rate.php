<?php
    namespace App\Model;
    use Datetime;

    class Rate
    {
        private array $value;
        private Datetime $date;

        public function __construct($value, DateTime $date = null)
        {
            $this->value = (array) $value;
            $this->date = $date ?: new DateTime();
        }

        /**
         * @return array
         */
        public function getValue(): array
        {
            return $this->value;
        }

        /**
         * @return string
         */
        public function getDate(): string
        {
            return $this->date->format('Y-m-d H:i:s');
        }

    }