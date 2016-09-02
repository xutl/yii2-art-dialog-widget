<?php
/**
 * Leaps Framework [ WE CAN DO IT JUST THINK IT ]
 *
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2015 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace xutl\dialog;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * Wrapper for Plupload
 * A multiple file upload utility using Flash, Silverlight, Google Gears, HTML5 or BrowserPlus.
 * @url http://www.plupload.com/
 * @version 1.0
 * @author Bound State Software
 */
class Plupload extends InputWidget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \Leaps\Helper\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options;


    public $dialogOptions = [];

    /**
     * @var array the options for rendering the toggle button tag.
     *      The toggle button is used to toggle the visibility of the modal window.
     *      If this property is false, no toggle button will be rendered.
     *      The following special options are supported:
     *      - tag: string, the tag name of the button. Defaults to 'button'.
     *      - label: string, the label of the button. Defaults to 'Show'.
     *      The rest of the options will be rendered as the HTML attributes of the button tag.
     *      Please refer to the [Modal plugin help](http://getbootstrap.com/javascript/#modals)
     *      for the supported HTML attributes.
     */
    public $toggleButton = false;

    /**
     * @var string the type of the input tag. Currently only 'text' and 'tel' are supported.
     * @see https://github.com/RobinHerbots/jquery.inputmask
     * @since 2.0.6
     */
    public $type = 'text';

    public function init()
    {
        parent::init();
        $this->options = ArrayHelper::merge([
            'class' => 'form-control',
        ], $this->options);
        $this->dialogOptions = ArrayHelper::merge([
            'toggleButton' => [
                'label' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-circle-arrow-up']) . Yii::t('yii','Upload'),
                'class' => 'btn btn-default',
            ],
            'clientOptions' => [
                'fixed' => true,
                'title' => '上传附件',
                'padding' => 5,
                'width' => 810,
                'height' => 400,
                'url' => Url::toRoute(['/user/favorite/index'])
            ]
        ], $this->dialogOptions);
    }

    /**
     * {@inheritDoc}
     * @see \Leaps\Base\Widget::run()
     */
    public function run()
    {
        echo Html::beginTag('div', ['class' => 'input-group']);
        $this->renderToggleButton();
        echo Html::beginTag('span', ['class' => 'input-group-btn']);
        echo \xutongle\dialog\Dialog::widget($this->dialogOptions);
        echo Html::endTag('span');
        echo Html::endTag('div');
    }

    /**
     * 渲染触发按钮
     *
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if ($this->hasModel()) {
            echo Html::activeInput($this->type, $this->model, $this->attribute, $this->options);
        } else {
            echo Html::input($this->type, $this->name, $this->value, $this->options);
        }
    }
}
