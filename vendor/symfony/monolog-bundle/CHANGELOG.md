## 3.1.2 (2017-11-06)

* fix invalid usage of count()

## 3.1.1 (2017-09-26)

* added support for Symfony 4

## 3.1.0 (2017-03-26)

* Added support for server_log handler
* Allow configuring VERBOSITY_QUIET in console handlers
* Fixed autowiring
* Fixed slackbot handler not escaping channel names properly
* Fixed slackbot handler requiring `slack_team` instead of `team` to be configured

## 3.0.3 (2017-01-10)

* Fixed deprecation notices when using Symfony 3.3+ and PHP7+

## 3.0.2 (2017-01-03)

* Revert disabling DebugHandler in CLI environments
* Update configuration for slack handlers for Monolog 1.22 new options
* Revert the removal of the DebugHandlerPass (needed for Symfony <3.2)

## 3.0.1 (2016-11-15)

* Removed obsolete code (DebugHandlerPass)

## 3.0.0 (2016-11-06)

* Removed class parameters for the container configuration
* Bumped minimum version of supported Symfony version to 2.7
* Removed `NotFoundActivationStrategy` (the bundle now uses the class from MonologBridge)
