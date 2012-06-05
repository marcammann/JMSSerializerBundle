<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\SerializerBundle\Serializer\Exclusion;

use JMS\SerializerBundle\Metadata\ClassMetadata;
use JMS\SerializerBundle\Metadata\PropertyMetadata;

class GroupExclusionStrategy implements ExclusionStrategyInterface
{
    private $groups;

    public function __construct($groups)
    {   
        $this->groups = $groups;
    }

    public function shouldSkipClass(ClassMetadata $metadata)
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldSkipProperty(PropertyMetadata $property)
    {
        if (is_null($this->groups) && (is_null($property->groups) || (is_array($property->groups) && in_array('default', $property->groups)))) {
            return False;
        } else if (is_null($this->groups)) {
            return True;
        }

		if (!is_array($property->groups) || array_intersect($this->groups, $property->groups)) {
			return False;
		}

        return True;
    }
}