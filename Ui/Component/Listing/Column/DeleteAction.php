<?php

/*
 * This file is part of the Magento2 Force Login Module package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column;

use \Magento\Framework\UrlInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class DeleteAction
 * @package bitExpert\ForceCustomerLogin\Ui\Component\Listing\Column
 */
class DeleteAction extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['whitelist_entry_id']) ||
                !isset($item['editable']) ||
                '1' !== $item['editable']) {
                continue;
            }

            $viewUrlPath = $this->getData('config/viewUrlPath') ?: '#';
            $item[$this->getData('name')] = [
                'edit' => [
                    'href' => $this->urlBuilder->getUrl(
                        $viewUrlPath,
                        [
                            'id' => $item['whitelist_entry_id']
                        ]
                    ),
                    'label' => $this->getLabel()
                ]
            ];
        }

        return $dataSource;
    }

    /**
     * @return \Magento\Framework\Phrase|mixed|string
     */
    protected function getLabel()
    {
        return __('Delete');
    }
}
