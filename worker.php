<?php

require(__DIR__.'/config.php');

// Worker - process all queues
// $worker = new Qutee\Worker;
// while (true) {
//     try {
//         $worker->run();
//     } catch (Exception $e) {
//         echo $e->getMessage();
//     }
// }

// Or, with more configuration
$worker = new Qutee\Worker;
$worker
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