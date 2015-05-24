# FDuhPokerBundle

## Installation

Add the dependency:

```sh
$ composer require fduh/poker-bundle dev-master
```

Add the bundle:

```php
// app/AppKernel.php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Fduh\PokerBundle\FduhPokerBundle(),
            // Optional, for Google Chart
            new SaadTazi\GChartBundle\SaadTaziGChartBundle(),
        );
    }
}
```

## How to use

### Results Handler

After you created some seasons, events and results, you now want to manage players, rankings and scores. Here's how to
use the bundle:

```php
$resultsHandler = $this->get('poker.results_handler');
// Add events
$resultsHandler->addEvents($yourEvents);
// Or a season
$resultsHandler->addSeason($yourSeason);
```

Of course, you can retrieve events by using:

```php
// Reduces requests count
$events = $this->get('poker.repository.hydrated.event')->findAllViewableEventsByDateAsc();
```

Now there's how you should use the results handler in your template:

```twig
{% for eventData in resultsHandler.eventManager.eventsData %}
    {{ eventData.event }} // Access to the Event entity
    {# And other functions... #}
{% endfor %}

{% for playerData in resultsHandler.playerManager.playersData %}
    {{ playerData.player }} // Access to the Player entity
    {{ playerData.score }}
    {{ playerData.rank }}
    {{ playerData.wonEvents }}
    {# And a lot of functions... #}
{% endfor %}
```

Open *PlayerDataInterface.php* and *EventDataInterface.php* to read more about provided properties.

Watch a practical example at [standrewspokerclub.fr](http://www.standrewspokerclub.fr/result).

### Chart

If you want to display score evolution (in controller):

```php
$chartMaker = $this->get('poker.chart_maker');
$chartMaker->setSeason($season);
$chart = $chartMaker->getChart();

return array(
    'chart'  => $chart->toArray(),
    'width'  => $chartMaker->getWidth(),
    'height' => $chartMaker->getHeight()
    // ...
}
```

And in the template (mine for the example):

```html
<script>
    $(function() {
        {{ gchart_line_chart(chart, 'chart', width, height, null,
           { // your options }
          )
        }}
    });
</script>
```

Watch a practical example at [standrewspokerclub.fr](http://www.standrewspokerclub.fr/stats).

## Configuration

Reference dump:

```yml
fduh_poker:
    calculation_class: ~
```

If you want the bundle to calculate scores differently, override the *calculation_class* with a class implementing
*Fduh\PokerBundle\Calculator\CalculationStrategyInterface*.

Run this command to recalculate every score:

```sh
$ php app/console poker:update-scores
```

## To do

- TwigExtensions
- a lot of things.....

Feel free to contribute this project.
