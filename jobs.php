<?php

require(__DIR__.'/config.php');

$queuePersistor = new Qutee\Persistor\Beanstalk();
$queuePersistor->setOptions($beanstalkdParams);

$queue          = new Qutee\Queue();
$queue->setPersistor($queuePersistor);

// Or, with more configuration
$worker = new Qutee\Worker;
$worker
	->setQueue($queue)
    ->setInterval(60)                           // Run every 30 seconds
    //->setPriority(Task::PRIORITY_HIGH)          // Will only do tasks of this priority
;

while (true) {
    try {
        if (null !== ($task = $worker->run())) {
            echo 'Ran task: '. $task->getName() . PHP_EOL;
        }
    } catch (Exception $e) {
        echo 'Error: '. $e->getMessage() . PHP_EOL;
    }
}