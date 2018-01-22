# MarkShust_MaintenanceKey

Magento module to enable maintenance mode viewing by parameter key.

## Overview

Instead of creating a file at `var/.maintenance.ip` with the list of IP addresses to allow in maintenance mode, instead create a file at `var/.maintenance.key` to allow access by list of allowed keys. This allows developers with dynamic or changing IP addresses to access Magento while the site is in maintenance mode.

## Install

`composer require markoshust/magento-module-maintenance-key`

## Usage

1. Create the file: `./var/.maintenance.key`
2. This file should contain a comma-delimited list of keys, for example:
	`67BBB06F-7C54-48E0-A124-44DC22649809,883233B6-8756-460D-A3D2-8C901C21FCE7`
3. If the site contains the file `./var/.maintenance.flag`, the site will be deemed in maintenance mode.
4. The site can now be accessed by appending the `MAINTENANCE_KEY` parameter with a value allowed in the `./var/.maintenance.key` file, for example::
	`http://mysite.com/?MAINTENANCE_KEY=67BBB06F-7C54-48E0-A124-44DC22649809`
5. If the `./var/.maintenance.key` file does not exist, maintenance mode viewing will fallback to default methods.

## Extra

Use the [Requestly](https://www.requestly.in/) browser plugin to auto-append the `MAINTENANCE_KEY` parameter to a site's URL.
