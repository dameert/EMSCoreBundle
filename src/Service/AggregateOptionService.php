<?php

namespace EMS\CoreBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Elastica\Aggregation\AbstractAggregation;
use Elastica\Aggregation\Terms;
use EMS\CommonBundle\Elasticsearch\Document\EMSSource;
use EMS\CommonBundle\Service\ElasticaService;
use EMS\CoreBundle\Entity\AggregateOption;
use Psr\Log\LoggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class AggregateOptionService extends EntityService
{
    /** @var string */
    const CONTENT_TYPES_AGGREGATION = 'types';
    /** @var string */
    const INDEXES_AGGREGATION = 'indexes';
    /** @var ElasticaService */
    private $elasticaService;

    public function __construct(Registry $doctrine, LoggerInterface $logger, TranslatorInterface $translator, ElasticaService $elasticaService)
    {
        parent::__construct($doctrine, $logger, $translator);
        $this->elasticaService = $elasticaService;
    }

    protected function getRepositoryIdentifier()
    {
        return 'EMSCoreBundle:AggregateOption';
    }
    
    protected function getEntityName()
    {
        return 'Aggregate Option';
    }

    /**
     * @return AbstractAggregation[]
     */
    public function getAllAggregations(): array
    {
        $contentTypeField = '_type';
        if (\version_compare($this->elasticaService->getVersion(), '6.0') >= 0) {
            $contentTypeField = EMSSource::FIELD_CONTENT_TYPE;
        }
        $contentTypeAggregation = new Terms(self::CONTENT_TYPES_AGGREGATION);
        $contentTypeAggregation->setSize(15);
        $contentTypeAggregation->setField($contentTypeField);

        $indexAggregation = new Terms(self::INDEXES_AGGREGATION);
        $indexAggregation->setSize(15);
        $indexAggregation->setField('_index');

        $aggregations = [$contentTypeAggregation, $indexAggregation];

        foreach ($this->getAll() as $id => $option) {
            if (!$option instanceof AggregateOption) {
                throw new \RuntimeException('Unexpected AggregateOption object');
            }
            $aggregations[] = $this->parseAggregation(sprintf('agg_%s', $id), $option->getConfigDecoded());
        }
        return $aggregations;
    }

    /**
     * @param array<mixed> $config
     */
    private function parseAggregation(string $name, array $config): AbstractAggregation
    {
        $aggregation = null;
        if (\is_array($config['terms'] ?? null)) {
            return $this->parseTermsAgg($name, $config);
        }
        throw new \RuntimeException('Unsupported aggregation type');
    }

    /**
     * @param array<mixed> $config
     */
    private function parseTermsAgg(string $name, array $config): AbstractAggregation
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'size' => 10,
            'field' => null,
            'order' => null,
            'min_doc_count' => 1,
        ])->isRequired('field');
        $termsConfig = $resolver->resolve($config['terms'] ?? []);

        $aggregation = new Terms($name);
        $aggregation->setSize($termsConfig['size'] ?? 10);
        $fieldName = $termsConfig['field'] ?? null;
        if (!\is_string($fieldName)) {
            throw new \RuntimeException('Field parameter is mandatory for Terms aggregation');
        }
        $aggregation->setField($fieldName);
        $minDocCount = $termsConfig['min_doc_count'] ?? null;
        if (!\is_int($minDocCount)) {
            throw new \RuntimeException('Unexpected min_doc_count value');
        }
        $aggregation->setMinimumDocumentCount($minDocCount);

        $order = $termsConfig['order'] ?? null;
        if ($order === null || !\is_array($order) || \count($order) !== 1) {
            return $aggregation;
        }
        foreach ($order as $field => $direction) {
            $aggregation->setOrder($field, $direction);
        }
        return $aggregation;
    }
}
