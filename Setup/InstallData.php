<?php

/**
 * @Author: Ngo Quang Cuong
 * @Date:   2017-07-28 07:55:00
 * @Last Modified by:   nquangcuong
 * @Last Modified time: 2017-07-28 07:55:30
 */

namespace PHPCuong\FaqSampleData\Setup;

use Magento\Framework\Setup;

class InstallData implements Setup\InstallDataInterface
{
    /**
     * @var Setup\SampleData\Executor
     */
    protected $executor;

    /**
     * @var Installer
     */
    protected $installer;

    public function __construct(
        \Magento\Framework\Setup\SampleData\Executor $executor,
        \PHPCuong\FaqSampleData\Setup\Installer $installer)
    {
        $this->executor = $executor;
        $this->installer = $installer;
    }

    /**
     * {@inheritdoc}
     */
    public function install(Setup\ModuleDataSetupInterface $setup, Setup\ModuleContextInterface $moduleContext)
    {
        $this->executor->exec($this->installer);
    }
}
