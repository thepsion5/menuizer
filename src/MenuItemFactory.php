<?php

namespace Thepsion5\Menuizer;

use Thepsion5\Menuizer\Exceptions\InvalidMenuItemException;

class MenuItemFactory
{
    /**
     * @var array
     */
    protected $urlRuleMap = array(
        'url'   => 'url',
        'route' => 'route',
    );

    /**
     * @var array
     */
    protected $attributeRuleMap = array(
        'label' => 'label',
        'attrs' => 'attributes'
    );

    /**
     * @var array
     */
    protected $attrRuleAliases = array(
        'id',
        'class'
    );

    /**
     * @var UrlGenerator
     */
    protected $generator;

    public function __construct(UrlGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function makeFromRuleString($ruleString)
    {
        $parsedRules = $this->parseRulesFromString($ruleString);
        return $this->makeFromRules($parsedRules);
    }

    public function makeFromRules(array $parsedRules)
    {
        $url = '#';
        $label = '';
        $attributes = array();
        foreach($parsedRules as $rule => $params)
        {
            if($rule == '' && isset($params[0])) {
                if($params[0][0] == '#') {
                    $rule = 'url';
                    $url = $params[0];
                } elseif($params[0][0] == '/') {
                    $url = $params[0];
                    $rule = 'url';
                }
            }

            if(isset($this->urlRuleMap[$rule])) {
                $url = $this->generator->generateUrlFromRule($this->urlRuleMap[$rule], $params);
            } elseif($rule == 'label') {
                $label = $this->generateLabelFromRule($params);
            } elseif($rule == 'attrs' || in_array($rule, $this->attrRuleAliases)) {
                $attributes = $this->generateAttributesFromRule($rule, $params, $attributes);
            } elseif($this->generator->canUseNamedRoutes()) {
                $routeParams = $params;
                if($rule != '') {
                    array_unshift($routeParams, $rule);
                }
                $routeUrl = $this->generator->generateUrlFromRule('route', $routeParams);
                if($routeUrl) {
                    $url = $routeUrl;
                }
            } else {
                throw new InvalidMenuItemException("The [$rule] rule is not valid.");
            }
        }
        return new MenuItem($url, $label, $attributes);
    }

    protected function parseRulesFromString($ruleString)
    {
        $parsedRules = array();
        $ruleStrings = explode('|', $ruleString);
        foreach($ruleStrings as $singleRule) {
            $rule = StringHelper::splice(':', $singleRule);
            $ruleParams = StringHelper::toAssociativeArray($singleRule);
            if($rule == null && $singleRule[0] == '/') {
                $rule = 'url';
            }
            $parsedRules[$rule] = $ruleParams;
        }
        return $parsedRules;
    }

    /**
     * @param $params
     * @return mixed
     * @throws Exceptions\InvalidMenuItemException
     */
    protected function generateLabelFromRule($params)
    {
        if (count($params) < 1) {
            throw new InvalidMenuItemException("The [label] rule requires at least one parameter.");
        }
        $label = $params[0];
        return $label;
    }

    /**
     * @param $rule
     * @param $params
     * @param $attributes
     * @throws Exceptions\InvalidMenuItemException
     * @return array
     */
    protected function generateAttributesFromRule($rule, $params, $attributes)
    {
        if (count($params) < 1) {
            throw new InvalidMenuItemException("The [attrs] rule requires at least one parameter.");
        }
        if(in_array($rule, $this->attrRuleAliases)) {
            $attributes[$rule] = $params[0];
        } else {
            foreach ($params as $attribute => $value) {
                if (is_numeric($attribute)) {
                    $attributes[] = $value;
                } else {
                    $attributes[$attribute] = $value;
                }
            }
        }
        return $attributes;
    }
}
