<?php

class Ebizmarts_MageMonkey_Block_Adminhtml_Bulksync_QueueExport_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('bulksync_exportjobs_queue');
        $this->setUseAjax(TRUE);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('monkey/bulksyncExport')
					  	->getCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'=> Mage::helper('monkey')->__('ID'),
            'index' => 'id',
            'type' => 'number'
        ));

        $this->addColumn('data_source_entity', array(
            'header'=> Mage::helper('monkey')->__('Entity'),
            'index' => 'data_source_entity',
            'filter' => false,
            'sortable' => false,
        ));

        $this->addColumn('status', array(
            'header'=> Mage::helper('monkey')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'options' => Mage::getModel('monkey/system_config_source_bulksyncStatus')->toOption()
        ));

        $this->addColumn('processed_count', array(
            'header'=> Mage::helper('monkey')->__('# Processed'),
            'index' => 'processed_count',
            'type' => 'number'
        ));

        $this->addColumn('lists', array(
            'header'=> Mage::helper('monkey')->__('Lists'),
            'index' => 'lists',
            'filter' => false,
            'sortable' => false,
            'renderer' => 'Ebizmarts_MageMonkey_Block_Adminhtml_Renderer_Lists'
        ));

        $this->addColumn('updated_at', array(
            'header'=> Mage::helper('monkey')->__('Updated At'),
            'index' => 'updated_at',
            'type'  => 'datetime'
        ));

        $this->addColumn('created_at', array(
            'header'=> Mage::helper('monkey')->__('Created At'),
            'index' => 'created_at',
            'type'  => 'datetime'
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('monkey')->__('Action'),
                'width'     => '60px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('monkey')->__('Delete'),
                        'url'     => array('base' => '*/*/delete', 'params' => array('entity'=>'Export')),
                        'field'   => 'job_id',
                        'confirm' => Mage::helper('monkey')->__('Are you sure?')
                    ),
                    array(
                        'caption' => Mage::helper('monkey')->__('Reset Status'),
                        'url'     => array('base' => '*/*/reset', 'params' => array('entity'=>'Export')),
                        'field'   => 'job_id',
                        'confirm' => Mage::helper('monkey')->__('Are you sure you want to reset status to IDLE?')
                    ),
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true,
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return FALSE;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/exportgrid', array('_current' => true));
    }
}