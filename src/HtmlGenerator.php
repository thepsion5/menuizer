<?php
namespace Thepsion5\Menuizer;

class HtmlGenerator
{
    protected $templates = array(
        'default' => '<li><a href=":url" :attributes>:label</a></li>'
    );

    public function generateItemHtml($url, $label = '', array $attributeRules = array())
    {
        $htmlAttributes = $this->mergeAttributes($attributeRules);
        $attrString = $this->buildAttributeString($htmlAttributes);

        return $this->generateFilledTemplate($url, $label, $attrString);
    }

    public function setTemplate($templateString)
    {
        $this->templates['default'] = $templateString;
    }

    public function getTemplate()
    {
        return $this->templates['default'];
    }

    protected function mergeAttributes(array $attributeRules)
    {
        $attributes = array('class' => '');
        foreach($attributeRules as $ruleParams) {
            foreach($ruleParams as $ruleName => $param) {
                $attributes = $this->parseAttributeKeyValuePairs($param, $attributes);
            }
        }
        if($attributes['class'] == '') {
            unset($attributes['class']);
        } else {
            $attributes['class'] = ltrim($attributes['class']);
        }
        return $attributes;
    }

    protected function parseAttributeKeyValuePairs(array $pairs, array $attributes)
    {
        foreach($pairs as $pair) {
            $param = explode('=', $pair);
            $attributeName = $param[0];
            $attributeValue = (count($param) > 1) ? $param[1] : $param[0];

            if($attributeName == 'class') {
                $attributes['class'] .= ' ' . $attributeValue;
            } else {
                $attributes[$attributeName] = $attributeValue;
            }
        }
        return $attributes;
    }

    protected function buildAttributeString(array $attributes)
    {
        $string = '';
        foreach($attributes as $attribute => $value) {
            $string .= " $attribute=\"$value\"";
        }

        return ltrim($string);
    }

    protected function generateFilledTemplate($url, $label, $attributes)
    {
        return str_replace(
            array(':url', ':attributes', ':label'),
            array($url, $attributes, $label),
            $this->templates['default']
        );
    }
}
