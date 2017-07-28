<?php

/**
 * @Author: Ngo Quang Cuong
 * @Date:   2017-07-28 07:55:42
 * @Last Modified by:   nquangcuong
 * @Last Modified time: 2017-07-28 07:59:08
 */

namespace PHPCuong\FaqSampleData\Setup;

class Installer implements \Magento\Framework\Setup\SampleData\InstallerInterface
{
    /**
     * @var \PHPCuong\FaqSampleData\Model\Faq
     */
    private $faq;

    /**
     * @var \PHPCuong\FaqSampleData\Model\FaqCategory
     */
    private $faqCategory;

    /**
     * @param \PHPCuong\FaqSampleData\Model\Faq $faq
     * @param \PHPCuong\FaqSampleData\Model\FaqCategory $faqCategory
     */
    public function __construct(
        \PHPCuong\FaqSampleData\Model\Faq $faq,
        \PHPCuong\FaqSampleData\Model\FaqCategory $faqCategory
    ) {
        $this->faq = $faq;
        $this->faqCategory = $faqCategory;
    }

    /**
     * {@inheritdoc}
     */
    public function install()
    {
        $this->faqCategory->install(['PHPCuong_FaqSampleData::fixtures/faqCategory.csv']);
        $this->faq->install(['PHPCuong_FaqSampleData::fixtures/faq.csv']);
    }
}
