# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 5.2.0

### Added

- [#227](https://github.com/bitExpert/magento2-force-login/pull/227) add support for php 8.2

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#228](https://github.com/bitExpert/magento2-force-login/pull/228) Add module enabled check to plugin enabled

## 5.1.0

### Added

- [#224](https://github.com/bitExpert/magento2-force-login/pull/224) Make module compatible with Magento 2.4.5
- [#218](https://github.com/bitExpert/magento2-force-login/pull/218) Upgrade PHPStan to version 1.7
- [#217](https://github.com/bitExpert/magento2-force-login/pull/217) Update readme, add composer error instructions

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#223](https://github.com/bitExpert/magento2-force-login/pull/223) Add db_schema_whitelist.json to fix issue

## 5.0.1

### Added

- [#214](https://github.com/bitExpert/magento2-force-login/pull/214) Migrate to db_schema.xml
- [#213](https://github.com/bitExpert/magento2-force-login/pull/213) Extend CI pipeline with more Magento versions

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#215](https://github.com/bitExpert/magento2-force-login/pull/215) Update default routes

## 5.0.0

### Added

- [#211](https://github.com/bitExpert/magento2-force-login/pull/211) M2.4.4 compability
- [#197](https://github.com/bitExpert/magento2-force-login/pull/197) Allow the store column to be sorted in the grid view
- [#188](https://github.com/bitExpert/magento2-force-login/pull/188) Paypal Ipn

### Deprecated

- [#202](https://github.com/bitExpert/magento2-force-login/pull/202) Only support M2.4.x

### Removed

- Nothing.

### Fixed

- [#212](https://github.com/bitExpert/magento2-force-login/pull/212) Allow Magento admin to log in as customer
- [#209](https://github.com/bitExpert/magento2-force-login/pull/209) Fix bug for wrong redirect on customer login and account confirmation
- [#206](https://github.com/bitExpert/magento2-force-login/pull/206) Homepage Redirect After Login Leads To incorrect url
- [#198](https://github.com/bitExpert/magento2-force-login/pull/198) Fix undefined method call

## 4.1.0

### Added

- [#191](https://github.com/bitExpert/magento2-force-login/pull/191) Added support for Magento 2.4
- [#187](https://github.com/bitExpert/magento2-force-login/pull/187) Skip dynamic asset request
- [#186](https://github.com/bitExpert/magento2-force-login/pull/186) Fixed registration redirect

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#192](https://github.com/bitExpert/magento2-force-login/issues/192) force login in store redirects to default login
- [#180](https://github.com/bitExpert/magento2-force-login/issues/180) Customers get whoops.... after registering
- [#179](https://github.com/bitExpert/magento2-force-login/issues/179) Improve menu placement: fix compatibility with B2B
- [#161](https://github.com/bitExpert/magento2-force-login/issues/161) After login in shows css page

## 4.0.1

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#167](https://github.com/bitExpert/magento2-force-login/pull/167) Password Reset not working

## 4.0.0

### Added

- [#172](https://github.com/bitExpert/magento2-force-login/pull/172) Add PHP7.3 and Magento 2.3.3 version requirements
- [#165](https://github.com/bitExpert/magento2-force-login/pull/165) Added /stores/store/switch and /stores/store/redirect to the whitelist 
- [#155](https://github.com/bitExpert/magento2-force-login/pull/155) Add varnish ESI url to whitelist
- [#154](https://github.com/bitExpert/magento2-force-login/pull/154) Add option to configure to force https redirect

### Deprecated

- Nothing.

### Removed

- [#160](https://github.com/bitExpert/magento2-force-login/pull/160) Drop Magento 2.1 & 2.2 compatibility

### Fixed

- Nothing.

## 3.2.0

### Added

- [#140](https://github.com/bitExpert/magento2-force-login/pull/140) Magento 2.3 compatibility

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.1.0

### Added

- [#134](https://github.com/bitExpert/magento2-force-login/pull/134) Fixed an issue where GET query parameters get stripped
- [#123](https://github.com/bitExpert/magento2-force-login/pull/123) Fixes for multiple stores with store name in path
- [#118](https://github.com/bitExpert/magento2-force-login/pull/118) Add path /customer/account/resetpasswordpost to the default setup
- [#108](https://github.com/bitExpert/magento2-force-login/pull/108) Add Magento EQP tool in Travis build 
- [#105](https://github.com/bitExpert/magento2-force-login/pull/105) Add coveralls.io support in Travis build

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.0.1

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#104](https://github.com/bitExpert/magento2-force-login/pull/104) Fix to make sure the module will work with Magento 2.1 and 2.2 

## 3.0.0

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#98](https://github.com/bitExpert/magento2-force-login/pull/98) Convert "bitExpert" namespace to "BitExpert" to fix the Magento 2.2 XSD issue
- [#99](https://github.com/bitExpert/magento2-force-login/pull/99) Don't store AJAX requests as after login url
- [#100](https://github.com/bitExpert/magento2-force-login/pull/100) Apply fixes sugested by the EQP tool
- [#101](https://github.com/bitExpert/magento2-force-login/pull/101) Update docs to fix typos and reflect latest changes
- [#102](https://github.com/bitExpert/magento2-force-login/pull/102) Rename button "delete"

## 2.3.0

### Added

- [#88](https://github.com/bitExpert/magento2-force-login/pull/88) Migrated from using observers to hook into router chain
- [#89](https://github.com/bitExpert/magento2-force-login/pull/89) Enabled edition of default whitelist routes
- [#92](https://github.com/bitExpert/magento2-force-login/pull/92) Fixed syntax issue in layout xml, invalid block definition

### Deprecated

- Nothing.

### Removed

- [#88](https://github.com/bitExpert/magento2-force-login/pull/88) Usage of observers (LoginRequiredOnCustomerSessionInitObserver, LoginRequiredOnVisitorInitObserver) and event hooks (customer_session_init, visitor_init) have been removed

### Fixed

- [#83](https://github.com/bitExpert/magento2-force-login/pull/83) 404 pages do not show when logged out
- [#84](https://github.com/bitExpert/magento2-force-login/pull/84) Disable registration isn't possible
- [#91](https://github.com/bitExpert/magento2-force-login/pull/91) Whitelist is Not works for Magento 2.2.0

## 2.2.0

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#85](https://github.com/bitExpert/magento2-force-login/pull/85) Incompatible with Magento 2.2

## 2.1.0

### Added

- [#82](https://github.com/bitExpert/magento2-force-login/pull/82) Fixed invalid position of tag resource in system.xml
- [#78](https://github.com/bitExpert/magento2-force-login/pull/78) Move backend configuration to customer > customer configuration section
- [#77](https://github.com/bitExpert/magento2-force-login/pull/77) Provides backwards compatibility by set strategy for existing rules to regex matcher instead of static
- [#76](https://github.com/bitExpert/magento2-force-login/pull/76) Static matcher now canonicalizes url and rule to omit differences of trailing slashes
- [#60](https://github.com/bitExpert/magento2-force-login/pull/60) Behavior Setting for Matcher

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#81](https://github.com/bitExpert/magento2-force-login/pull/81) Error in admin pages due to invalid XML
- [#79](https://github.com/bitExpert/magento2-force-login/pull/79) Invalid system.xml file
- [#75](https://github.com/bitExpert/magento2-force-login/pull/75) Static matching strategy could ignore ending slash
- [#74](https://github.com/bitExpert/magento2-force-login/pull/74) Upgrade to 2.1 RC2 from 2 breaks backward compatibility of rules
- [#73](https://github.com/bitExpert/magento2-force-login/pull/73) Force login top level system config tab is overkill
- [#72](https://github.com/bitExpert/magento2-force-login/pull/72) Fixes on class resolution

## 2.0.2

### Added

- [#71](https://github.com/bitExpert/magento2-force-login/pull/71) Moved events.xml to frontend/events.xml

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#68](https://github.com/bitExpert/magento2-force-login/pull/68) Activating the module also blocks the backend

## 2.0.1

### Added

- [#67](https://github.com/bitExpert/magento2-force-login/pull/67) Resolve redirect loop from login to customer dashboard

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- [#66](https://github.com/bitExpert/magento2-force-login/pull/66) Redirect loop

## 2.0.0

### Added

- Changed type namings in DI to match best practice.
- Respect configured login option behavior.
- Added own session handler.
- [#63](https://github.com/bitExpert/magento2-force-login/pull/63) Updated resource ACL
- [#62](https://github.com/bitExpert/magento2-force-login/pull/62) Move UpgradeSchema to InstallSchema
- [#54](https://github.com/bitExpert/magento2-force-login/pull/54) Added configuration to enabled or disabled the module
- [#43](https://github.com/bitExpert/magento2-force-login/pull/43) Added additional default rules for sitemap.xml and robots.txt
- [#26](https://github.com/bitExpert/magento2-force-login/pull/26) Added cache control to redirecting
- [#24](https://github.com/bitExpert/magento2-force-login/pull/24) Added configuration to set target url

### Deprecated

- Nothing.

### Removed

- Removed full qualification of namespace representation type name to match best practice.

### Fixed

- Refactored code structure.
- [#64](https://github.com/bitExpert/magento2-force-login/pull/64) ACL error when accessing Store Configuration
- [#61](https://github.com/bitExpert/magento2-force-login/pull/61) Setup install then upgrade fails
- [#35](https://github.com/bitExpert/magento2-force-login/pull/35) Redirection after logging in

## 1.3.1

### Added

-  Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Increased version number in module.xml

## 1.3.0

### Added

-  Unified support for Magento 2.0 and Magento 2.1

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.2.4

### Added

-  [#27](https://github.com/bitExpert/magento2-force-login/pull/27) Allow to edit default paths

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#22](https://github.com/bitExpert/magento2-force-login/issue/22) disable /customer/account/create

## 1.2.3

### Added

-  [#21](https://github.com/bitExpert/magento2-force-login/pull/21) Updated docs to match Magento2 marketplace regulations

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  Nothing.

## 1.2.2

### Added

-  [#15](https://github.com/bitExpert/magento2-force-login/pull/18) Fixed appliance of whitelist repository collection filter

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#14](https://github.com/bitExpert/magento2-force-login/issues/14) Whitelist entire website or store view

## 1.2.1

### Added

-  [#15](https://github.com/bitExpert/magento2-force-login/pull/15) Reduced the quotation of the whitelist entries to allow some regular expressions

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#14](https://github.com/bitExpert/magento2-force-login/issues/14) Whitelist entire website or store view

## 1.2.0

### Added

-  [#11](https://github.com/bitExpert/magento2-force-login/issues/11) Magento 2.1 compatibility added

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.1.7

### Added

-  [#27](https://github.com/bitExpert/magento2-force-login/pull/27) Allow to edit default paths

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#22](https://github.com/bitExpert/magento2-force-login/issue/22) disable /customer/account/create

## 1.1.6

### Added

-  [#20](https://github.com/bitExpert/magento2-force-login/pull/20) Updated docs to match Magento2 marketplace regulations

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  Nothing.

## 1.1.5

### Added

-  [#15](https://github.com/bitExpert/magento2-force-login/pull/18) Fixed appliance of whitelist repository collection filter

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#14](https://github.com/bitExpert/magento2-force-login/issues/14) Whitelist entire website or store view

## 1.1.4

### Added

-  [#15](https://github.com/bitExpert/magento2-force-login/pull/15) Reduced the quotation of the whitelist entries to allow some regular expressions

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#14](https://github.com/bitExpert/magento2-force-login/issues/14) Whitelist entire website or store view

## 1.1.3

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#7](https://github.com/bitExpert/magento2-force-login/pull/9) Fixed new whitlist entry saving fails

## 1.1.2

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#6](https://github.com/bitExpert/magento2-force-login/pull/6) Fix/missing customer session check

## 1.1.1

### Added

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#5](https://github.com/bitExpert/magento2-force-login/pull/5) Fixed issue with storefront prefix

## 1.1.0

### Added

-  [#4](https://github.com/bitExpert/magento2-force-login/pull/4) Added an administrative UI for configure the whitelist entries

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 1.0.1

### Added

-  [#1](https://github.com/bitExpert/magento2-force-login/pull/1) added links to ignore-urls

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

-  [#3](https://github.com/bitExpert/magento2-force-login/pull/3) Fix #2 issues with DI compilation
-  [#2](https://github.com/bitExpert/magento2-force-login/issues/2) DI Compilation fails due to dependency duplicate on older magento2 versions then 2.0.4

## 1.0.0

Initial release of the Force Login module for Magento2.
