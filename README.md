# Feature toggle library

## Usage
```php
use \PascalHeidmann\FeatureToggle\FeatureToggleManager;
use \PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use \PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;
use \PascalHeidmann\FeatureToggle\Repository\ArrayFeatureToggleRepository;

$featureToggle = new FeatureToggle('my-feature-toggle', new StaticCondition(true));
$repository = new ArrayFeatureToggleRepository($featureToggle);
$featureToggleManager = new FeatureToggleManager($repository);

// ...

$canIUseMyFeature = $featureToggleManager->get('my-feature-toggle'); // true
```