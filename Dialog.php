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
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Dialog 模态框
 *
 * @see https://github.com/aui/artDialog
 */
class Dialog extends Widget
{
    /**
     * @var array the HTML attributes for the widget container tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array the options for the underlying Bootstrap JS plugin.
     * Please refer to the corresponding Bootstrap plugin Web page for possible options.
     * For example, [this page](http://getbootstrap.com/javascript/#modals) shows
     * how to use the "Modal" plugin and the supported options (e.g. "remote").
     */
    public $clientOptions = [];

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
     * {@inheritDoc}
     * @see \yii\base\Object::init()
     */
    public function init()
    {
        parent::init();
        if (!isset ($this->options ['id'])) {
            $this->options ['id'] = $this->getId();
        }
        $this->clientOptions = array_merge(
            [
                'okValue' => Yii::t('app', 'Ok'),
                'cancelValue' => Yii::t('app', 'Cancel')
            ], $this->clientOptions);
        if ($this->toggleButton !== false) {
            if (!isset ($this->toggleButton ['data-target'])) {
                $this->toggleButton ['data-target'] = 'dialog_' . $this->options ['id'];
            }
        }
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Widget::run()
     */
    public function run()
    {
        $view = $this->getView();
        DialogAsset::register($view);
        $options = Json::encode($this->clientOptions);
        $view->registerJs("jQuery(document).on('click','[data-target^=dialog_{$this->options ['id']}]',function(e){dialog($options).show();});");
        echo $this->renderToggleButton() . "\n";
    }

    /**
     * Renders the toggle button.
     *
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if (($toggleButton = $this->toggleButton) !== false) {
            $tag = ArrayHelper::remove($toggleButton, 'tag', 'button');
            $label = ArrayHelper::remove($toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset ($toggleButton ['type'])) {
                $toggleButton ['type'] = 'button';
            }
            return Html::tag($tag, $label, $toggleButton);
        } else {
            return null;
        }
    }
}
