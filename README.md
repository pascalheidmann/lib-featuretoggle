# Feature toggle library

## Usage

```php
use \PascalHeidmann\FeatureToggle\FeatureToggleManager;
use \PascalHeidmann\FeatureToggle\Condition\StaticCondition;
use \PascalHeidmann\FeatureToggle\FeatureToggle\FeatureToggle;
use \PascalHeidmann\FeatureToggle\Repository\ArrayRepository;

$featureToggle = new FeatureToggle('my-feature-toggle', new StaticCondition(true));
$repository = new ArrayRepository($featureToggle);
$featureToggleManager = new FeatureToggleManager($repository);

// ...

$canIUseMyFeature = $featureToggleManager->get('my-feature-toggle'); // true
```

## Advanced usage

You might want to have multiple repositories: one which loads each feature toggle from persistent storage like a
database or Redis, and in front of it hardcoded values with `ArrayFeatureToggleRepository`:

```php
$overrideFeatureToggle = new StaticFeatureToggle('my-feature-toggle', false);
$staticRepository = new ArrayFeatureToggleRepository($overrideFeatureToggle);

// ...
// database has feature-toggle `my-feature-toggle` with value `true`
$dbRepository = new DatabaseFeatureToggleRepository($user);
// first repo with key wins
$featureToggleManager = new FeatureToggleManager($staticRepository, $dbRepository);

// ...
$canIUseMyFeature = $featureToggleManager->get('my-feature-toggle'); // false

```
