<?php

/**
 * @Author: Ngo Quang Cuong
 * @Date:   2017-07-28 07:59:32
 * @Last Modified by:   nquangcuong
 * @Last Modified time: 2017-07-28 08:02:49
 */

namespace PHPCuong\FaqSampleData\Model;

use Magento\Framework\Setup\SampleData\Context as SampleDataContext;

class Faq
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
     * @var \PHPCuong\Faq\Model\FaqFactory
     *
     */
    protected $faqFactory;

    /**
     * @var \PHPCuong\Faq\Model\Faqcat
     */
    protected $faqCat;

    /**
     * @param SampleDataContext $sampleDataContext
     * @param \PHPCuong\Faq\Model\FaqFactory $faqFactory
     * @param \PHPCuong\Faq\Model\Faqcat $faqCat
     */
    public function __construct(
        SampleDataContext $sampleDataContext,
        \PHPCuong\Faq\Model\FaqFactory $faqFactory,
        \PHPCuong\Faq\Model\Faqcat $faqCat
    ) {
        $this->fixtureManager = $sampleDataContext->getFixtureManager();
        $this->csvReader = $sampleDataContext->getCsvReader();
        $this->faqFactory = $faqFactory;
        $this->faqCat = $faqCat;
    }

    /**
     * @param array $fixtures
     * @throws \Exception
     */
    public function install(array $fixtures)
    {
        $categoryIds = $this->getCategoriesId();
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

                $this->faqFactory->create()
                    ->load($row['identifier'], 'identifier')
                    ->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID])
                    ->setCategoryId($categoryIds[array_rand($categoryIds, 1)])
                    ->addData($row)
                    ->save();
            }
        }
    }

    /**
     * Get the FAQ Category Ids
     * @return array
     */
    public function getCategoriesId()
    {
        return $this->faqCat->getCollection()
                ->addFieldToFilter('is_active', ['eq' => '1'])
                ->setCurPage(1)
                ->setPageSize(8)
                ->setOrder('category_id')
                ->getAllIds();
    }
}
