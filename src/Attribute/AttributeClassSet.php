<?php
/**
 * @copyright   Copyright (C) 2010-2024 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

class AttributeClassSet extends AttributeSet
{
	const SEARCH_WIDGET_TYPE = self::SEARCH_WIDGET_TYPE_STRING;

	public function __construct($sCode, array $aParams)
	{
		$this->m_sCode = $sCode;
		$this->aCSSClasses[] = 'attribute-class-attcode-set';
		$aParams['allowed_values'] = new ValueSetEnumClasses($aParams['class_category'] ?? 'business', $aParams['more_values'] ?? '');
		parent::__construct($sCode, $aParams);
	}

	public static function ListExpectedParams()
	{
		return array_merge(parent::ListExpectedParams(), ['class_category' /*, 'more_values', 'max_items'*/]);
	}

	public function GetMaxSize()
	{
		return max(255, 15 * $this->GetMaxItems());
	}

	public function GetDefaultValue(DBObject $oHostObject = null)
	{
		$sDefault = parent::GetDefaultValue($oHostObject);
		if (!$this->IsNullAllowed() && $this->IsNull($sDefault)) {
			// For this kind of attribute specifying null as default value
			// is authorized even if null is not allowed

			// Pick the first one...
			$aClasses = $this->GetAllowedValues();
			$sDefault = key($aClasses);
		}

		return $sDefault;
	}

	public function RequiresIndex()
	{
		return true;
	}

	public function GetBasicFilterLooseOperator()
	{
		return '=';
	}

	/**
	 * @param $value
	 * @param \DBObject $oHostObject
	 * @param bool $bLocalize
	 *
	 * @return string|null
	 *
	 * @throws \Exception
	 */
	public function GetAsHTML($value, $oHostObject = null, $bLocalize = true)
	{
		if ($value instanceof ormSet) {
			$value = $value->GetValues();
		}
		if (is_array($value)) {
			if ($bLocalize) {
				$aLocalizedValues = [];
				foreach ($value as $sClassName) {
					try {
						$sValue = MetaModel::GetName($sClassName);
						$aLocalizedValues[] = '<span class="attribute-set-item" data-code="'.$sClassName.'" data-label="'.$sValue.'" data-description="" data-tooltip-content="'.$sValue.'">'.$sValue.'</span>';
					} catch (Exception $e) {
						// Ignore bad values
					}
				}
				$value = $aLocalizedValues;
			}
			$value = implode('', $value);
		}

		return '<span class="'.implode(' ', $this->aCSSClasses).'">'.$value.'</span>';
	}

	public function IsNull($proposedValue)
	{
		return empty($proposedValue);
	}

}