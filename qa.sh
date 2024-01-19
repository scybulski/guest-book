#!/bin/bash

composer phpunit
composer fixer
composer phpstan
