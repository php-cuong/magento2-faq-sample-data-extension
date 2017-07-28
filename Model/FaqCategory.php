<?php

/**
 * @Author: Ngo Quang Cuong
 * @Date:   2017-07-28 08:03:34
 * @Last Modified by:   nquangcuong
 * @Last Modified time: 2017-07-28 08:03:57
 */

namespace PHPCuong\FaqSampleData\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

class FaqCategory
{
    /**
     * @var \Magento\Framework\Setup\SampleData\FixtureManager
     */
    private $fixtureManager;

    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvReader;

    /**
     * @var \PHPCuong\Faq\Model\FaqcatFactory
     */
    protected $faqCategoryFactory;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param \PHPCuong\Faq\Model\FaqcatFactory $faqCategoryFactory
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \PHPCuong\Faq\Model\FaqcatFactory $faqCategoryFactory
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->faqCategoryFactory = $faqCategoryFactory;
    }

    /**
     * @param array $fixtures
     * @throws \Exception
     */
    public function install(array $fixtures)
    {
        foreach ($fixtures as $fileName) {
            $fileName = $this->fixtureManager->getFixture($fileName);
            if (!file_exists($fileName)) {
                continue;
            }

            $rows = $this->csvReader->getData($fileName);
            $header = array_shift($rows);

            foreach ($rows as $row) {
                $data = [];
                foreach ($row as $key => $value) {
                    $data[$header[$key]] = $value;
                }
                $row = $data;

                $this->faqCategoryFactory->create()
                    ->load($row['identifier'], 'identifier')
                    ->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                    ->addData($row)
                    ->save();
            }
        }
    }
}
