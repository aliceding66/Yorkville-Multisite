/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	__webpack_require__(1);
	__webpack_require__(7);
	__webpack_require__(16);
	module.exports = __webpack_require__(20);


/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;'use strict';

	!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(2), __webpack_require__(3), __webpack_require__(4), __webpack_require__(5), __webpack_require__(6)], __WEBPACK_AMD_DEFINE_RESULT__ = function (_, Hooks, React, MailPoet, ReactStringReplace) {

	  // Track once per page load
	  var trackCampaignNameTyped = _.once(function () {
	    MailPoet.trackEvent('User has typed a GA campaign name', { 'MailPoet Premium version': window.mailpoet_premium_version });
	  });

	  var addGACampaignField = function addGACampaignField(fields) {
	    var tipLink = 'http://beta.docs.mailpoet.com/article/187-track-your-newsletters-subscribers-in-google-analytics';
	    var tip = ReactStringReplace(MailPoet.I18n.t('gaCampaignTip'), /\[link\](.*?)\[\/link\]/g, function (match, i) {
	      return React.createElement(
	        'a',
	        {
	          key: i,
	          href: tipLink,
	          target: '_blank'
	        },
	        match
	      );
	    });

	    fields.push({
	      name: 'ga_campaign',
	      label: MailPoet.I18n.t('gaCampaignLine'),
	      tip: tip,
	      type: 'text',
	      onBeforeChange: trackCampaignNameTyped
	    });

	    return fields;
	  };

	  Hooks.addFilter('mailpoet_newsletters_3rd_step_fields', addGACampaignField);
	}.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;//     Underscore.js 1.8.3
	//     http://underscorejs.org
	//     (c) 2009-2015 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
	//     Underscore may be freely distributed under the MIT license.

	'use strict';

	(function () {

	  // Baseline setup
	  // --------------

	  // Establish the root object, `window` in the browser, or `exports` on the server.
	  var root = this;

	  // Save the previous value of the `_` variable.
	  var previousUnderscore = root._;

	  // Save bytes in the minified (but not gzipped) version:
	  var ArrayProto = Array.prototype,
	      ObjProto = Object.prototype,
	      FuncProto = Function.prototype;

	  // Create quick reference variables for speed access to core prototypes.
	  var push = ArrayProto.push,
	      slice = ArrayProto.slice,
	      toString = ObjProto.toString,
	      hasOwnProperty = ObjProto.hasOwnProperty;

	  // All **ECMAScript 5** native function implementations that we hope to use
	  // are declared here.
	  var nativeIsArray = Array.isArray,
	      nativeKeys = Object.keys,
	      nativeBind = FuncProto.bind,
	      nativeCreate = Object.create;

	  // Naked function reference for surrogate-prototype-swapping.
	  var Ctor = function Ctor() {};

	  // Create a safe reference to the Underscore object for use below.
	  var _ = function _(obj) {
	    if (obj instanceof _) return obj;
	    if (!(this instanceof _)) return new _(obj);
	    this._wrapped = obj;
	  };

	  // Export the Underscore object for **Node.js**, with
	  // backwards-compatibility for the old `require()` API. If we're in
	  // the browser, add `_` as a global object.
	  if (true) {
	    if (typeof module !== 'undefined' && module.exports) {
	      exports = module.exports = _;
	    }
	    exports._ = _;
	  } else {
	    root._ = _;
	  }

	  // Current version.
	  _.VERSION = '1.8.3';

	  // Internal function that returns an efficient (for current engines) version
	  // of the passed-in callback, to be repeatedly applied in other Underscore
	  // functions.
	  var optimizeCb = function optimizeCb(func, context, argCount) {
	    if (context === void 0) return func;
	    switch (argCount == null ? 3 : argCount) {
	      case 1:
	        return function (value) {
	          return func.call(context, value);
	        };
	      case 2:
	        return function (value, other) {
	          return func.call(context, value, other);
	        };
	      case 3:
	        return function (value, index, collection) {
	          return func.call(context, value, index, collection);
	        };
	      case 4:
	        return function (accumulator, value, index, collection) {
	          return func.call(context, accumulator, value, index, collection);
	        };
	    }
	    return function () {
	      return func.apply(context, arguments);
	    };
	  };

	  // A mostly-internal function to generate callbacks that can be applied
	  // to each element in a collection, returning the desired result — either
	  // identity, an arbitrary callback, a property matcher, or a property accessor.
	  var cb = function cb(value, context, argCount) {
	    if (value == null) return _.identity;
	    if (_.isFunction(value)) return optimizeCb(value, context, argCount);
	    if (_.isObject(value)) return _.matcher(value);
	    return _.property(value);
	  };
	  _.iteratee = function (value, context) {
	    return cb(value, context, Infinity);
	  };

	  // An internal function for creating assigner functions.
	  var createAssigner = function createAssigner(keysFunc, undefinedOnly) {
	    return function (obj) {
	      var length = arguments.length;
	      if (length < 2 || obj == null) return obj;
	      for (var index = 1; index < length; index++) {
	        var source = arguments[index],
	            keys = keysFunc(source),
	            l = keys.length;
	        for (var i = 0; i < l; i++) {
	          var key = keys[i];
	          if (!undefinedOnly || obj[key] === void 0) obj[key] = source[key];
	        }
	      }
	      return obj;
	    };
	  };

	  // An internal function for creating a new object that inherits from another.
	  var baseCreate = function baseCreate(prototype) {
	    if (!_.isObject(prototype)) return {};
	    if (nativeCreate) return nativeCreate(prototype);
	    Ctor.prototype = prototype;
	    var result = new Ctor();
	    Ctor.prototype = null;
	    return result;
	  };

	  var property = function property(key) {
	    return function (obj) {
	      return obj == null ? void 0 : obj[key];
	    };
	  };

	  // Helper for collection methods to determine whether a collection
	  // should be iterated as an array or as an object
	  // Related: http://people.mozilla.org/~jorendorff/es6-draft.html#sec-tolength
	  // Avoids a very nasty iOS 8 JIT bug on ARM-64. #2094
	  var MAX_ARRAY_INDEX = Math.pow(2, 53) - 1;
	  var getLength = property('length');
	  var isArrayLike = function isArrayLike(collection) {
	    var length = getLength(collection);
	    return typeof length == 'number' && length >= 0 && length <= MAX_ARRAY_INDEX;
	  };

	  // Collection Functions
	  // --------------------

	  // The cornerstone, an `each` implementation, aka `forEach`.
	  // Handles raw objects in addition to array-likes. Treats all
	  // sparse array-likes as if they were dense.
	  _.each = _.forEach = function (obj, iteratee, context) {
	    iteratee = optimizeCb(iteratee, context);
	    var i, length;
	    if (isArrayLike(obj)) {
	      for (i = 0, length = obj.length; i < length; i++) {
	        iteratee(obj[i], i, obj);
	      }
	    } else {
	      var keys = _.keys(obj);
	      for (i = 0, length = keys.length; i < length; i++) {
	        iteratee(obj[keys[i]], keys[i], obj);
	      }
	    }
	    return obj;
	  };

	  // Return the results of applying the iteratee to each element.
	  _.map = _.collect = function (obj, iteratee, context) {
	    iteratee = cb(iteratee, context);
	    var keys = !isArrayLike(obj) && _.keys(obj),
	        length = (keys || obj).length,
	        results = Array(length);
	    for (var index = 0; index < length; index++) {
	      var currentKey = keys ? keys[index] : index;
	      results[index] = iteratee(obj[currentKey], currentKey, obj);
	    }
	    return results;
	  };

	  // Create a reducing function iterating left or right.
	  function createReduce(dir) {
	    // Optimized iterator function as using arguments.length
	    // in the main function will deoptimize the, see #1991.
	    function iterator(obj, iteratee, memo, keys, index, length) {
	      for (; index >= 0 && index < length; index += dir) {
	        var currentKey = keys ? keys[index] : index;
	        memo = iteratee(memo, obj[currentKey], currentKey, obj);
	      }
	      return memo;
	    }

	    return function (obj, iteratee, memo, context) {
	      iteratee = optimizeCb(iteratee, context, 4);
	      var keys = !isArrayLike(obj) && _.keys(obj),
	          length = (keys || obj).length,
	          index = dir > 0 ? 0 : length - 1;
	      // Determine the initial value if none is provided.
	      if (arguments.length < 3) {
	        memo = obj[keys ? keys[index] : index];
	        index += dir;
	      }
	      return iterator(obj, iteratee, memo, keys, index, length);
	    };
	  }

	  // **Reduce** builds up a single result from a list of values, aka `inject`,
	  // or `foldl`.
	  _.reduce = _.foldl = _.inject = createReduce(1);

	  // The right-associative version of reduce, also known as `foldr`.
	  _.reduceRight = _.foldr = createReduce(-1);

	  // Return the first value which passes a truth test. Aliased as `detect`.
	  _.find = _.detect = function (obj, predicate, context) {
	    var key;
	    if (isArrayLike(obj)) {
	      key = _.findIndex(obj, predicate, context);
	    } else {
	      key = _.findKey(obj, predicate, context);
	    }
	    if (key !== void 0 && key !== -1) return obj[key];
	  };

	  // Return all the elements that pass a truth test.
	  // Aliased as `select`.
	  _.filter = _.select = function (obj, predicate, context) {
	    var results = [];
	    predicate = cb(predicate, context);
	    _.each(obj, function (value, index, list) {
	      if (predicate(value, index, list)) results.push(value);
	    });
	    return results;
	  };

	  // Return all the elements for which a truth test fails.
	  _.reject = function (obj, predicate, context) {
	    return _.filter(obj, _.negate(cb(predicate)), context);
	  };

	  // Determine whether all of the elements match a truth test.
	  // Aliased as `all`.
	  _.every = _.all = function (obj, predicate, context) {
	    predicate = cb(predicate, context);
	    var keys = !isArrayLike(obj) && _.keys(obj),
	        length = (keys || obj).length;
	    for (var index = 0; index < length; index++) {
	      var currentKey = keys ? keys[index] : index;
	      if (!predicate(obj[currentKey], currentKey, obj)) return false;
	    }
	    return true;
	  };

	  // Determine if at least one element in the object matches a truth test.
	  // Aliased as `any`.
	  _.some = _.any = function (obj, predicate, context) {
	    predicate = cb(predicate, context);
	    var keys = !isArrayLike(obj) && _.keys(obj),
	        length = (keys || obj).length;
	    for (var index = 0; index < length; index++) {
	      var currentKey = keys ? keys[index] : index;
	      if (predicate(obj[currentKey], currentKey, obj)) return true;
	    }
	    return false;
	  };

	  // Determine if the array or object contains a given item (using `===`).
	  // Aliased as `includes` and `include`.
	  _.contains = _.includes = _.include = function (obj, item, fromIndex, guard) {
	    if (!isArrayLike(obj)) obj = _.values(obj);
	    if (typeof fromIndex != 'number' || guard) fromIndex = 0;
	    return _.indexOf(obj, item, fromIndex) >= 0;
	  };

	  // Invoke a method (with arguments) on every item in a collection.
	  _.invoke = function (obj, method) {
	    var args = slice.call(arguments, 2);
	    var isFunc = _.isFunction(method);
	    return _.map(obj, function (value) {
	      var func = isFunc ? method : value[method];
	      return func == null ? func : func.apply(value, args);
	    });
	  };

	  // Convenience version of a common use case of `map`: fetching a property.
	  _.pluck = function (obj, key) {
	    return _.map(obj, _.property(key));
	  };

	  // Convenience version of a common use case of `filter`: selecting only objects
	  // containing specific `key:value` pairs.
	  _.where = function (obj, attrs) {
	    return _.filter(obj, _.matcher(attrs));
	  };

	  // Convenience version of a common use case of `find`: getting the first object
	  // containing specific `key:value` pairs.
	  _.findWhere = function (obj, attrs) {
	    return _.find(obj, _.matcher(attrs));
	  };

	  // Return the maximum element (or element-based computation).
	  _.max = function (obj, iteratee, context) {
	    var result = -Infinity,
	        lastComputed = -Infinity,
	        value,
	        computed;
	    if (iteratee == null && obj != null) {
	      obj = isArrayLike(obj) ? obj : _.values(obj);
	      for (var i = 0, length = obj.length; i < length; i++) {
	        value = obj[i];
	        if (value > result) {
	          result = value;
	        }
	      }
	    } else {
	      iteratee = cb(iteratee, context);
	      _.each(obj, function (value, index, list) {
	        computed = iteratee(value, index, list);
	        if (computed > lastComputed || computed === -Infinity && result === -Infinity) {
	          result = value;
	          lastComputed = computed;
	        }
	      });
	    }
	    return result;
	  };

	  // Return the minimum element (or element-based computation).
	  _.min = function (obj, iteratee, context) {
	    var result = Infinity,
	        lastComputed = Infinity,
	        value,
	        computed;
	    if (iteratee == null && obj != null) {
	      obj = isArrayLike(obj) ? obj : _.values(obj);
	      for (var i = 0, length = obj.length; i < length; i++) {
	        value = obj[i];
	        if (value < result) {
	          result = value;
	        }
	      }
	    } else {
	      iteratee = cb(iteratee, context);
	      _.each(obj, function (value, index, list) {
	        computed = iteratee(value, index, list);
	        if (computed < lastComputed || computed === Infinity && result === Infinity) {
	          result = value;
	          lastComputed = computed;
	        }
	      });
	    }
	    return result;
	  };

	  // Shuffle a collection, using the modern version of the
	  // [Fisher-Yates shuffle](http://en.wikipedia.org/wiki/Fisher–Yates_shuffle).
	  _.shuffle = function (obj) {
	    var set = isArrayLike(obj) ? obj : _.values(obj);
	    var length = set.length;
	    var shuffled = Array(length);
	    for (var index = 0, rand; index < length; index++) {
	      rand = _.random(0, index);
	      if (rand !== index) shuffled[index] = shuffled[rand];
	      shuffled[rand] = set[index];
	    }
	    return shuffled;
	  };

	  // Sample **n** random values from a collection.
	  // If **n** is not specified, returns a single random element.
	  // The internal `guard` argument allows it to work with `map`.
	  _.sample = function (obj, n, guard) {
	    if (n == null || guard) {
	      if (!isArrayLike(obj)) obj = _.values(obj);
	      return obj[_.random(obj.length - 1)];
	    }
	    return _.shuffle(obj).slice(0, Math.max(0, n));
	  };

	  // Sort the object's values by a criterion produced by an iteratee.
	  _.sortBy = function (obj, iteratee, context) {
	    iteratee = cb(iteratee, context);
	    return _.pluck(_.map(obj, function (value, index, list) {
	      return {
	        value: value,
	        index: index,
	        criteria: iteratee(value, index, list)
	      };
	    }).sort(function (left, right) {
	      var a = left.criteria;
	      var b = right.criteria;
	      if (a !== b) {
	        if (a > b || a === void 0) return 1;
	        if (a < b || b === void 0) return -1;
	      }
	      return left.index - right.index;
	    }), 'value');
	  };

	  // An internal function used for aggregate "group by" operations.
	  var group = function group(behavior) {
	    return function (obj, iteratee, context) {
	      var result = {};
	      iteratee = cb(iteratee, context);
	      _.each(obj, function (value, index) {
	        var key = iteratee(value, index, obj);
	        behavior(result, value, key);
	      });
	      return result;
	    };
	  };

	  // Groups the object's values by a criterion. Pass either a string attribute
	  // to group by, or a function that returns the criterion.
	  _.groupBy = group(function (result, value, key) {
	    if (_.has(result, key)) result[key].push(value);else result[key] = [value];
	  });

	  // Indexes the object's values by a criterion, similar to `groupBy`, but for
	  // when you know that your index values will be unique.
	  _.indexBy = group(function (result, value, key) {
	    result[key] = value;
	  });

	  // Counts instances of an object that group by a certain criterion. Pass
	  // either a string attribute to count by, or a function that returns the
	  // criterion.
	  _.countBy = group(function (result, value, key) {
	    if (_.has(result, key)) result[key]++;else result[key] = 1;
	  });

	  // Safely create a real, live array from anything iterable.
	  _.toArray = function (obj) {
	    if (!obj) return [];
	    if (_.isArray(obj)) return slice.call(obj);
	    if (isArrayLike(obj)) return _.map(obj, _.identity);
	    return _.values(obj);
	  };

	  // Return the number of elements in an object.
	  _.size = function (obj) {
	    if (obj == null) return 0;
	    return isArrayLike(obj) ? obj.length : _.keys(obj).length;
	  };

	  // Split a collection into two arrays: one whose elements all satisfy the given
	  // predicate, and one whose elements all do not satisfy the predicate.
	  _.partition = function (obj, predicate, context) {
	    predicate = cb(predicate, context);
	    var pass = [],
	        fail = [];
	    _.each(obj, function (value, key, obj) {
	      (predicate(value, key, obj) ? pass : fail).push(value);
	    });
	    return [pass, fail];
	  };

	  // Array Functions
	  // ---------------

	  // Get the first element of an array. Passing **n** will return the first N
	  // values in the array. Aliased as `head` and `take`. The **guard** check
	  // allows it to work with `_.map`.
	  _.first = _.head = _.take = function (array, n, guard) {
	    if (array == null) return void 0;
	    if (n == null || guard) return array[0];
	    return _.initial(array, array.length - n);
	  };

	  // Returns everything but the last entry of the array. Especially useful on
	  // the arguments object. Passing **n** will return all the values in
	  // the array, excluding the last N.
	  _.initial = function (array, n, guard) {
	    return slice.call(array, 0, Math.max(0, array.length - (n == null || guard ? 1 : n)));
	  };

	  // Get the last element of an array. Passing **n** will return the last N
	  // values in the array.
	  _.last = function (array, n, guard) {
	    if (array == null) return void 0;
	    if (n == null || guard) return array[array.length - 1];
	    return _.rest(array, Math.max(0, array.length - n));
	  };

	  // Returns everything but the first entry of the array. Aliased as `tail` and `drop`.
	  // Especially useful on the arguments object. Passing an **n** will return
	  // the rest N values in the array.
	  _.rest = _.tail = _.drop = function (array, n, guard) {
	    return slice.call(array, n == null || guard ? 1 : n);
	  };

	  // Trim out all falsy values from an array.
	  _.compact = function (array) {
	    return _.filter(array, _.identity);
	  };

	  // Internal implementation of a recursive `flatten` function.
	  var flatten = function flatten(input, shallow, strict, startIndex) {
	    var output = [],
	        idx = 0;
	    for (var i = startIndex || 0, length = getLength(input); i < length; i++) {
	      var value = input[i];
	      if (isArrayLike(value) && (_.isArray(value) || _.isArguments(value))) {
	        //flatten current level of array or arguments object
	        if (!shallow) value = flatten(value, shallow, strict);
	        var j = 0,
	            len = value.length;
	        output.length += len;
	        while (j < len) {
	          output[idx++] = value[j++];
	        }
	      } else if (!strict) {
	        output[idx++] = value;
	      }
	    }
	    return output;
	  };

	  // Flatten out an array, either recursively (by default), or just one level.
	  _.flatten = function (array, shallow) {
	    return flatten(array, shallow, false);
	  };

	  // Return a version of the array that does not contain the specified value(s).
	  _.without = function (array) {
	    return _.difference(array, slice.call(arguments, 1));
	  };

	  // Produce a duplicate-free version of the array. If the array has already
	  // been sorted, you have the option of using a faster algorithm.
	  // Aliased as `unique`.
	  _.uniq = _.unique = function (array, isSorted, iteratee, context) {
	    if (!_.isBoolean(isSorted)) {
	      context = iteratee;
	      iteratee = isSorted;
	      isSorted = false;
	    }
	    if (iteratee != null) iteratee = cb(iteratee, context);
	    var result = [];
	    var seen = [];
	    for (var i = 0, length = getLength(array); i < length; i++) {
	      var value = array[i],
	          computed = iteratee ? iteratee(value, i, array) : value;
	      if (isSorted) {
	        if (!i || seen !== computed) result.push(value);
	        seen = computed;
	      } else if (iteratee) {
	        if (!_.contains(seen, computed)) {
	          seen.push(computed);
	          result.push(value);
	        }
	      } else if (!_.contains(result, value)) {
	        result.push(value);
	      }
	    }
	    return result;
	  };

	  // Produce an array that contains the union: each distinct element from all of
	  // the passed-in arrays.
	  _.union = function () {
	    return _.uniq(flatten(arguments, true, true));
	  };

	  // Produce an array that contains every item shared between all the
	  // passed-in arrays.
	  _.intersection = function (array) {
	    var result = [];
	    var argsLength = arguments.length;
	    for (var i = 0, length = getLength(array); i < length; i++) {
	      var item = array[i];
	      if (_.contains(result, item)) continue;
	      for (var j = 1; j < argsLength; j++) {
	        if (!_.contains(arguments[j], item)) break;
	      }
	      if (j === argsLength) result.push(item);
	    }
	    return result;
	  };

	  // Take the difference between one array and a number of other arrays.
	  // Only the elements present in just the first array will remain.
	  _.difference = function (array) {
	    var rest = flatten(arguments, true, true, 1);
	    return _.filter(array, function (value) {
	      return !_.contains(rest, value);
	    });
	  };

	  // Zip together multiple lists into a single array -- elements that share
	  // an index go together.
	  _.zip = function () {
	    return _.unzip(arguments);
	  };

	  // Complement of _.zip. Unzip accepts an array of arrays and groups
	  // each array's elements on shared indices
	  _.unzip = function (array) {
	    var length = array && _.max(array, getLength).length || 0;
	    var result = Array(length);

	    for (var index = 0; index < length; index++) {
	      result[index] = _.pluck(array, index);
	    }
	    return result;
	  };

	  // Converts lists into objects. Pass either a single array of `[key, value]`
	  // pairs, or two parallel arrays of the same length -- one of keys, and one of
	  // the corresponding values.
	  _.object = function (list, values) {
	    var result = {};
	    for (var i = 0, length = getLength(list); i < length; i++) {
	      if (values) {
	        result[list[i]] = values[i];
	      } else {
	        result[list[i][0]] = list[i][1];
	      }
	    }
	    return result;
	  };

	  // Generator function to create the findIndex and findLastIndex functions
	  function createPredicateIndexFinder(dir) {
	    return function (array, predicate, context) {
	      predicate = cb(predicate, context);
	      var length = getLength(array);
	      var index = dir > 0 ? 0 : length - 1;
	      for (; index >= 0 && index < length; index += dir) {
	        if (predicate(array[index], index, array)) return index;
	      }
	      return -1;
	    };
	  }

	  // Returns the first index on an array-like that passes a predicate test
	  _.findIndex = createPredicateIndexFinder(1);
	  _.findLastIndex = createPredicateIndexFinder(-1);

	  // Use a comparator function to figure out the smallest index at which
	  // an object should be inserted so as to maintain order. Uses binary search.
	  _.sortedIndex = function (array, obj, iteratee, context) {
	    iteratee = cb(iteratee, context, 1);
	    var value = iteratee(obj);
	    var low = 0,
	        high = getLength(array);
	    while (low < high) {
	      var mid = Math.floor((low + high) / 2);
	      if (iteratee(array[mid]) < value) low = mid + 1;else high = mid;
	    }
	    return low;
	  };

	  // Generator function to create the indexOf and lastIndexOf functions
	  function createIndexFinder(dir, predicateFind, sortedIndex) {
	    return function (array, item, idx) {
	      var i = 0,
	          length = getLength(array);
	      if (typeof idx == 'number') {
	        if (dir > 0) {
	          i = idx >= 0 ? idx : Math.max(idx + length, i);
	        } else {
	          length = idx >= 0 ? Math.min(idx + 1, length) : idx + length + 1;
	        }
	      } else if (sortedIndex && idx && length) {
	        idx = sortedIndex(array, item);
	        return array[idx] === item ? idx : -1;
	      }
	      if (item !== item) {
	        idx = predicateFind(slice.call(array, i, length), _.isNaN);
	        return idx >= 0 ? idx + i : -1;
	      }
	      for (idx = dir > 0 ? i : length - 1; idx >= 0 && idx < length; idx += dir) {
	        if (array[idx] === item) return idx;
	      }
	      return -1;
	    };
	  }

	  // Return the position of the first occurrence of an item in an array,
	  // or -1 if the item is not included in the array.
	  // If the array is large and already in sort order, pass `true`
	  // for **isSorted** to use binary search.
	  _.indexOf = createIndexFinder(1, _.findIndex, _.sortedIndex);
	  _.lastIndexOf = createIndexFinder(-1, _.findLastIndex);

	  // Generate an integer Array containing an arithmetic progression. A port of
	  // the native Python `range()` function. See
	  // [the Python documentation](http://docs.python.org/library/functions.html#range).
	  _.range = function (start, stop, step) {
	    if (stop == null) {
	      stop = start || 0;
	      start = 0;
	    }
	    step = step || 1;

	    var length = Math.max(Math.ceil((stop - start) / step), 0);
	    var range = Array(length);

	    for (var idx = 0; idx < length; idx++, start += step) {
	      range[idx] = start;
	    }

	    return range;
	  };

	  // Function (ahem) Functions
	  // ------------------

	  // Determines whether to execute a function as a constructor
	  // or a normal function with the provided arguments
	  var executeBound = function executeBound(sourceFunc, boundFunc, context, callingContext, args) {
	    if (!(callingContext instanceof boundFunc)) return sourceFunc.apply(context, args);
	    var self = baseCreate(sourceFunc.prototype);
	    var result = sourceFunc.apply(self, args);
	    if (_.isObject(result)) return result;
	    return self;
	  };

	  // Create a function bound to a given object (assigning `this`, and arguments,
	  // optionally). Delegates to **ECMAScript 5**'s native `Function.bind` if
	  // available.
	  _.bind = function (func, context) {
	    if (nativeBind && func.bind === nativeBind) return nativeBind.apply(func, slice.call(arguments, 1));
	    if (!_.isFunction(func)) throw new TypeError('Bind must be called on a function');
	    var args = slice.call(arguments, 2);
	    var bound = function bound() {
	      return executeBound(func, bound, context, this, args.concat(slice.call(arguments)));
	    };
	    return bound;
	  };

	  // Partially apply a function by creating a version that has had some of its
	  // arguments pre-filled, without changing its dynamic `this` context. _ acts
	  // as a placeholder, allowing any combination of arguments to be pre-filled.
	  _.partial = function (func) {
	    var boundArgs = slice.call(arguments, 1);
	    var bound = function bound() {
	      var position = 0,
	          length = boundArgs.length;
	      var args = Array(length);
	      for (var i = 0; i < length; i++) {
	        args[i] = boundArgs[i] === _ ? arguments[position++] : boundArgs[i];
	      }
	      while (position < arguments.length) args.push(arguments[position++]);
	      return executeBound(func, bound, this, this, args);
	    };
	    return bound;
	  };

	  // Bind a number of an object's methods to that object. Remaining arguments
	  // are the method names to be bound. Useful for ensuring that all callbacks
	  // defined on an object belong to it.
	  _.bindAll = function (obj) {
	    var i,
	        length = arguments.length,
	        key;
	    if (length <= 1) throw new Error('bindAll must be passed function names');
	    for (i = 1; i < length; i++) {
	      key = arguments[i];
	      obj[key] = _.bind(obj[key], obj);
	    }
	    return obj;
	  };

	  // Memoize an expensive function by storing its results.
	  _.memoize = function (func, hasher) {
	    var memoize = function memoize(key) {
	      var cache = memoize.cache;
	      var address = '' + (hasher ? hasher.apply(this, arguments) : key);
	      if (!_.has(cache, address)) cache[address] = func.apply(this, arguments);
	      return cache[address];
	    };
	    memoize.cache = {};
	    return memoize;
	  };

	  // Delays a function for the given number of milliseconds, and then calls
	  // it with the arguments supplied.
	  _.delay = function (func, wait) {
	    var args = slice.call(arguments, 2);
	    return setTimeout(function () {
	      return func.apply(null, args);
	    }, wait);
	  };

	  // Defers a function, scheduling it to run after the current call stack has
	  // cleared.
	  _.defer = _.partial(_.delay, _, 1);

	  // Returns a function, that, when invoked, will only be triggered at most once
	  // during a given window of time. Normally, the throttled function will run
	  // as much as it can, without ever going more than once per `wait` duration;
	  // but if you'd like to disable the execution on the leading edge, pass
	  // `{leading: false}`. To disable execution on the trailing edge, ditto.
	  _.throttle = function (func, wait, options) {
	    var context, args, result;
	    var timeout = null;
	    var previous = 0;
	    if (!options) options = {};
	    var later = function later() {
	      previous = options.leading === false ? 0 : _.now();
	      timeout = null;
	      result = func.apply(context, args);
	      if (!timeout) context = args = null;
	    };
	    return function () {
	      var now = _.now();
	      if (!previous && options.leading === false) previous = now;
	      var remaining = wait - (now - previous);
	      context = this;
	      args = arguments;
	      if (remaining <= 0 || remaining > wait) {
	        if (timeout) {
	          clearTimeout(timeout);
	          timeout = null;
	        }
	        previous = now;
	        result = func.apply(context, args);
	        if (!timeout) context = args = null;
	      } else if (!timeout && options.trailing !== false) {
	        timeout = setTimeout(later, remaining);
	      }
	      return result;
	    };
	  };

	  // Returns a function, that, as long as it continues to be invoked, will not
	  // be triggered. The function will be called after it stops being called for
	  // N milliseconds. If `immediate` is passed, trigger the function on the
	  // leading edge, instead of the trailing.
	  _.debounce = function (func, wait, immediate) {
	    var timeout, args, context, timestamp, result;

	    var later = function later() {
	      var last = _.now() - timestamp;

	      if (last < wait && last >= 0) {
	        timeout = setTimeout(later, wait - last);
	      } else {
	        timeout = null;
	        if (!immediate) {
	          result = func.apply(context, args);
	          if (!timeout) context = args = null;
	        }
	      }
	    };

	    return function () {
	      context = this;
	      args = arguments;
	      timestamp = _.now();
	      var callNow = immediate && !timeout;
	      if (!timeout) timeout = setTimeout(later, wait);
	      if (callNow) {
	        result = func.apply(context, args);
	        context = args = null;
	      }

	      return result;
	    };
	  };

	  // Returns the first function passed as an argument to the second,
	  // allowing you to adjust arguments, run code before and after, and
	  // conditionally execute the original function.
	  _.wrap = function (func, wrapper) {
	    return _.partial(wrapper, func);
	  };

	  // Returns a negated version of the passed-in predicate.
	  _.negate = function (predicate) {
	    return function () {
	      return !predicate.apply(this, arguments);
	    };
	  };

	  // Returns a function that is the composition of a list of functions, each
	  // consuming the return value of the function that follows.
	  _.compose = function () {
	    var args = arguments;
	    var start = args.length - 1;
	    return function () {
	      var i = start;
	      var result = args[start].apply(this, arguments);
	      while (i--) result = args[i].call(this, result);
	      return result;
	    };
	  };

	  // Returns a function that will only be executed on and after the Nth call.
	  _.after = function (times, func) {
	    return function () {
	      if (--times < 1) {
	        return func.apply(this, arguments);
	      }
	    };
	  };

	  // Returns a function that will only be executed up to (but not including) the Nth call.
	  _.before = function (times, func) {
	    var memo;
	    return function () {
	      if (--times > 0) {
	        memo = func.apply(this, arguments);
	      }
	      if (times <= 1) func = null;
	      return memo;
	    };
	  };

	  // Returns a function that will be executed at most one time, no matter how
	  // often you call it. Useful for lazy initialization.
	  _.once = _.partial(_.before, 2);

	  // Object Functions
	  // ----------------

	  // Keys in IE < 9 that won't be iterated by `for key in ...` and thus missed.
	  var hasEnumBug = !({ toString: null }).propertyIsEnumerable('toString');
	  var nonEnumerableProps = ['valueOf', 'isPrototypeOf', 'toString', 'propertyIsEnumerable', 'hasOwnProperty', 'toLocaleString'];

	  function collectNonEnumProps(obj, keys) {
	    var nonEnumIdx = nonEnumerableProps.length;
	    var constructor = obj.constructor;
	    var proto = _.isFunction(constructor) && constructor.prototype || ObjProto;

	    // Constructor is a special case.
	    var prop = 'constructor';
	    if (_.has(obj, prop) && !_.contains(keys, prop)) keys.push(prop);

	    while (nonEnumIdx--) {
	      prop = nonEnumerableProps[nonEnumIdx];
	      if (prop in obj && obj[prop] !== proto[prop] && !_.contains(keys, prop)) {
	        keys.push(prop);
	      }
	    }
	  }

	  // Retrieve the names of an object's own properties.
	  // Delegates to **ECMAScript 5**'s native `Object.keys`
	  _.keys = function (obj) {
	    if (!_.isObject(obj)) return [];
	    if (nativeKeys) return nativeKeys(obj);
	    var keys = [];
	    for (var key in obj) if (_.has(obj, key)) keys.push(key);
	    // Ahem, IE < 9.
	    if (hasEnumBug) collectNonEnumProps(obj, keys);
	    return keys;
	  };

	  // Retrieve all the property names of an object.
	  _.allKeys = function (obj) {
	    if (!_.isObject(obj)) return [];
	    var keys = [];
	    for (var key in obj) keys.push(key);
	    // Ahem, IE < 9.
	    if (hasEnumBug) collectNonEnumProps(obj, keys);
	    return keys;
	  };

	  // Retrieve the values of an object's properties.
	  _.values = function (obj) {
	    var keys = _.keys(obj);
	    var length = keys.length;
	    var values = Array(length);
	    for (var i = 0; i < length; i++) {
	      values[i] = obj[keys[i]];
	    }
	    return values;
	  };

	  // Returns the results of applying the iteratee to each element of the object
	  // In contrast to _.map it returns an object
	  _.mapObject = function (obj, iteratee, context) {
	    iteratee = cb(iteratee, context);
	    var keys = _.keys(obj),
	        length = keys.length,
	        results = {},
	        currentKey;
	    for (var index = 0; index < length; index++) {
	      currentKey = keys[index];
	      results[currentKey] = iteratee(obj[currentKey], currentKey, obj);
	    }
	    return results;
	  };

	  // Convert an object into a list of `[key, value]` pairs.
	  _.pairs = function (obj) {
	    var keys = _.keys(obj);
	    var length = keys.length;
	    var pairs = Array(length);
	    for (var i = 0; i < length; i++) {
	      pairs[i] = [keys[i], obj[keys[i]]];
	    }
	    return pairs;
	  };

	  // Invert the keys and values of an object. The values must be serializable.
	  _.invert = function (obj) {
	    var result = {};
	    var keys = _.keys(obj);
	    for (var i = 0, length = keys.length; i < length; i++) {
	      result[obj[keys[i]]] = keys[i];
	    }
	    return result;
	  };

	  // Return a sorted list of the function names available on the object.
	  // Aliased as `methods`
	  _.functions = _.methods = function (obj) {
	    var names = [];
	    for (var key in obj) {
	      if (_.isFunction(obj[key])) names.push(key);
	    }
	    return names.sort();
	  };

	  // Extend a given object with all the properties in passed-in object(s).
	  _.extend = createAssigner(_.allKeys);

	  // Assigns a given object with all the own properties in the passed-in object(s)
	  // (https://developer.mozilla.org/docs/Web/JavaScript/Reference/Global_Objects/Object/assign)
	  _.extendOwn = _.assign = createAssigner(_.keys);

	  // Returns the first key on an object that passes a predicate test
	  _.findKey = function (obj, predicate, context) {
	    predicate = cb(predicate, context);
	    var keys = _.keys(obj),
	        key;
	    for (var i = 0, length = keys.length; i < length; i++) {
	      key = keys[i];
	      if (predicate(obj[key], key, obj)) return key;
	    }
	  };

	  // Return a copy of the object only containing the whitelisted properties.
	  _.pick = function (object, oiteratee, context) {
	    var result = {},
	        obj = object,
	        iteratee,
	        keys;
	    if (obj == null) return result;
	    if (_.isFunction(oiteratee)) {
	      keys = _.allKeys(obj);
	      iteratee = optimizeCb(oiteratee, context);
	    } else {
	      keys = flatten(arguments, false, false, 1);
	      iteratee = function (value, key, obj) {
	        return key in obj;
	      };
	      obj = Object(obj);
	    }
	    for (var i = 0, length = keys.length; i < length; i++) {
	      var key = keys[i];
	      var value = obj[key];
	      if (iteratee(value, key, obj)) result[key] = value;
	    }
	    return result;
	  };

	  // Return a copy of the object without the blacklisted properties.
	  _.omit = function (obj, iteratee, context) {
	    if (_.isFunction(iteratee)) {
	      iteratee = _.negate(iteratee);
	    } else {
	      var keys = _.map(flatten(arguments, false, false, 1), String);
	      iteratee = function (value, key) {
	        return !_.contains(keys, key);
	      };
	    }
	    return _.pick(obj, iteratee, context);
	  };

	  // Fill in a given object with default properties.
	  _.defaults = createAssigner(_.allKeys, true);

	  // Creates an object that inherits from the given prototype object.
	  // If additional properties are provided then they will be added to the
	  // created object.
	  _.create = function (prototype, props) {
	    var result = baseCreate(prototype);
	    if (props) _.extendOwn(result, props);
	    return result;
	  };

	  // Create a (shallow-cloned) duplicate of an object.
	  _.clone = function (obj) {
	    if (!_.isObject(obj)) return obj;
	    return _.isArray(obj) ? obj.slice() : _.extend({}, obj);
	  };

	  // Invokes interceptor with the obj, and then returns obj.
	  // The primary purpose of this method is to "tap into" a method chain, in
	  // order to perform operations on intermediate results within the chain.
	  _.tap = function (obj, interceptor) {
	    interceptor(obj);
	    return obj;
	  };

	  // Returns whether an object has a given set of `key:value` pairs.
	  _.isMatch = function (object, attrs) {
	    var keys = _.keys(attrs),
	        length = keys.length;
	    if (object == null) return !length;
	    var obj = Object(object);
	    for (var i = 0; i < length; i++) {
	      var key = keys[i];
	      if (attrs[key] !== obj[key] || !(key in obj)) return false;
	    }
	    return true;
	  };

	  // Internal recursive comparison function for `isEqual`.
	  var eq = function eq(a, b, aStack, bStack) {
	    // Identical objects are equal. `0 === -0`, but they aren't identical.
	    // See the [Harmony `egal` proposal](http://wiki.ecmascript.org/doku.php?id=harmony:egal).
	    if (a === b) return a !== 0 || 1 / a === 1 / b;
	    // A strict comparison is necessary because `null == undefined`.
	    if (a == null || b == null) return a === b;
	    // Unwrap any wrapped objects.
	    if (a instanceof _) a = a._wrapped;
	    if (b instanceof _) b = b._wrapped;
	    // Compare `[[Class]]` names.
	    var className = toString.call(a);
	    if (className !== toString.call(b)) return false;
	    switch (className) {
	      // Strings, numbers, regular expressions, dates, and booleans are compared by value.
	      case '[object RegExp]':
	      // RegExps are coerced to strings for comparison (Note: '' + /a/i === '/a/i')
	      case '[object String]':
	        // Primitives and their corresponding object wrappers are equivalent; thus, `"5"` is
	        // equivalent to `new String("5")`.
	        return '' + a === '' + b;
	      case '[object Number]':
	        // `NaN`s are equivalent, but non-reflexive.
	        // Object(NaN) is equivalent to NaN
	        if (+a !== +a) return +b !== +b;
	        // An `egal` comparison is performed for other numeric values.
	        return +a === 0 ? 1 / +a === 1 / b : +a === +b;
	      case '[object Date]':
	      case '[object Boolean]':
	        // Coerce dates and booleans to numeric primitive values. Dates are compared by their
	        // millisecond representations. Note that invalid dates with millisecond representations
	        // of `NaN` are not equivalent.
	        return +a === +b;
	    }

	    var areArrays = className === '[object Array]';
	    if (!areArrays) {
	      if (typeof a != 'object' || typeof b != 'object') return false;

	      // Objects with different constructors are not equivalent, but `Object`s or `Array`s
	      // from different frames are.
	      var aCtor = a.constructor,
	          bCtor = b.constructor;
	      if (aCtor !== bCtor && !(_.isFunction(aCtor) && aCtor instanceof aCtor && _.isFunction(bCtor) && bCtor instanceof bCtor) && 'constructor' in a && 'constructor' in b) {
	        return false;
	      }
	    }
	    // Assume equality for cyclic structures. The algorithm for detecting cyclic
	    // structures is adapted from ES 5.1 section 15.12.3, abstract operation `JO`.

	    // Initializing stack of traversed objects.
	    // It's done here since we only need them for objects and arrays comparison.
	    aStack = aStack || [];
	    bStack = bStack || [];
	    var length = aStack.length;
	    while (length--) {
	      // Linear search. Performance is inversely proportional to the number of
	      // unique nested structures.
	      if (aStack[length] === a) return bStack[length] === b;
	    }

	    // Add the first object to the stack of traversed objects.
	    aStack.push(a);
	    bStack.push(b);

	    // Recursively compare objects and arrays.
	    if (areArrays) {
	      // Compare array lengths to determine if a deep comparison is necessary.
	      length = a.length;
	      if (length !== b.length) return false;
	      // Deep compare the contents, ignoring non-numeric properties.
	      while (length--) {
	        if (!eq(a[length], b[length], aStack, bStack)) return false;
	      }
	    } else {
	      // Deep compare objects.
	      var keys = _.keys(a),
	          key;
	      length = keys.length;
	      // Ensure that both objects contain the same number of properties before comparing deep equality.
	      if (_.keys(b).length !== length) return false;
	      while (length--) {
	        // Deep compare each member
	        key = keys[length];
	        if (!(_.has(b, key) && eq(a[key], b[key], aStack, bStack))) return false;
	      }
	    }
	    // Remove the first object from the stack of traversed objects.
	    aStack.pop();
	    bStack.pop();
	    return true;
	  };

	  // Perform a deep comparison to check if two objects are equal.
	  _.isEqual = function (a, b) {
	    return eq(a, b);
	  };

	  // Is a given array, string, or object empty?
	  // An "empty" object has no enumerable own-properties.
	  _.isEmpty = function (obj) {
	    if (obj == null) return true;
	    if (isArrayLike(obj) && (_.isArray(obj) || _.isString(obj) || _.isArguments(obj))) return obj.length === 0;
	    return _.keys(obj).length === 0;
	  };

	  // Is a given value a DOM element?
	  _.isElement = function (obj) {
	    return !!(obj && obj.nodeType === 1);
	  };

	  // Is a given value an array?
	  // Delegates to ECMA5's native Array.isArray
	  _.isArray = nativeIsArray || function (obj) {
	    return toString.call(obj) === '[object Array]';
	  };

	  // Is a given variable an object?
	  _.isObject = function (obj) {
	    var type = typeof obj;
	    return type === 'function' || type === 'object' && !!obj;
	  };

	  // Add some isType methods: isArguments, isFunction, isString, isNumber, isDate, isRegExp, isError.
	  _.each(['Arguments', 'Function', 'String', 'Number', 'Date', 'RegExp', 'Error'], function (name) {
	    _['is' + name] = function (obj) {
	      return toString.call(obj) === '[object ' + name + ']';
	    };
	  });

	  // Define a fallback version of the method in browsers (ahem, IE < 9), where
	  // there isn't any inspectable "Arguments" type.
	  if (!_.isArguments(arguments)) {
	    _.isArguments = function (obj) {
	      return _.has(obj, 'callee');
	    };
	  }

	  // Optimize `isFunction` if appropriate. Work around some typeof bugs in old v8,
	  // IE 11 (#1621), and in Safari 8 (#1929).
	  if (typeof /./ != 'function' && typeof Int8Array != 'object') {
	    _.isFunction = function (obj) {
	      return typeof obj == 'function' || false;
	    };
	  }

	  // Is a given object a finite number?
	  _.isFinite = function (obj) {
	    return isFinite(obj) && !isNaN(parseFloat(obj));
	  };

	  // Is the given value `NaN`? (NaN is the only number which does not equal itself).
	  _.isNaN = function (obj) {
	    return _.isNumber(obj) && obj !== +obj;
	  };

	  // Is a given value a boolean?
	  _.isBoolean = function (obj) {
	    return obj === true || obj === false || toString.call(obj) === '[object Boolean]';
	  };

	  // Is a given value equal to null?
	  _.isNull = function (obj) {
	    return obj === null;
	  };

	  // Is a given variable undefined?
	  _.isUndefined = function (obj) {
	    return obj === void 0;
	  };

	  // Shortcut function for checking if an object has a given property directly
	  // on itself (in other words, not on a prototype).
	  _.has = function (obj, key) {
	    return obj != null && hasOwnProperty.call(obj, key);
	  };

	  // Utility Functions
	  // -----------------

	  // Run Underscore.js in *noConflict* mode, returning the `_` variable to its
	  // previous owner. Returns a reference to the Underscore object.
	  _.noConflict = function () {
	    root._ = previousUnderscore;
	    return this;
	  };

	  // Keep the identity function around for default iteratees.
	  _.identity = function (value) {
	    return value;
	  };

	  // Predicate-generating functions. Often useful outside of Underscore.
	  _.constant = function (value) {
	    return function () {
	      return value;
	    };
	  };

	  _.noop = function () {};

	  _.property = property;

	  // Generates a function for a given object that returns a given property.
	  _.propertyOf = function (obj) {
	    return obj == null ? function () {} : function (key) {
	      return obj[key];
	    };
	  };

	  // Returns a predicate for checking whether an object has a given set of
	  // `key:value` pairs.
	  _.matcher = _.matches = function (attrs) {
	    attrs = _.extendOwn({}, attrs);
	    return function (obj) {
	      return _.isMatch(obj, attrs);
	    };
	  };

	  // Run a function **n** times.
	  _.times = function (n, iteratee, context) {
	    var accum = Array(Math.max(0, n));
	    iteratee = optimizeCb(iteratee, context, 1);
	    for (var i = 0; i < n; i++) accum[i] = iteratee(i);
	    return accum;
	  };

	  // Return a random integer between min and max (inclusive).
	  _.random = function (min, max) {
	    if (max == null) {
	      max = min;
	      min = 0;
	    }
	    return min + Math.floor(Math.random() * (max - min + 1));
	  };

	  // A (possibly faster) way to get the current timestamp as an integer.
	  _.now = Date.now || function () {
	    return new Date().getTime();
	  };

	  // List of HTML entities for escaping.
	  var escapeMap = {
	    '&': '&amp;',
	    '<': '&lt;',
	    '>': '&gt;',
	    '"': '&quot;',
	    "'": '&#x27;',
	    '`': '&#x60;'
	  };
	  var unescapeMap = _.invert(escapeMap);

	  // Functions for escaping and unescaping strings to/from HTML interpolation.
	  var createEscaper = function createEscaper(map) {
	    var escaper = function escaper(match) {
	      return map[match];
	    };
	    // Regexes for identifying a key that needs to be escaped
	    var source = '(?:' + _.keys(map).join('|') + ')';
	    var testRegexp = RegExp(source);
	    var replaceRegexp = RegExp(source, 'g');
	    return function (string) {
	      string = string == null ? '' : '' + string;
	      return testRegexp.test(string) ? string.replace(replaceRegexp, escaper) : string;
	    };
	  };
	  _.escape = createEscaper(escapeMap);
	  _.unescape = createEscaper(unescapeMap);

	  // If the value of the named `property` is a function then invoke it with the
	  // `object` as context; otherwise, return it.
	  _.result = function (object, property, fallback) {
	    var value = object == null ? void 0 : object[property];
	    if (value === void 0) {
	      value = fallback;
	    }
	    return _.isFunction(value) ? value.call(object) : value;
	  };

	  // Generate a unique integer id (unique within the entire client session).
	  // Useful for temporary DOM ids.
	  var idCounter = 0;
	  _.uniqueId = function (prefix) {
	    var id = ++idCounter + '';
	    return prefix ? prefix + id : id;
	  };

	  // By default, Underscore uses ERB-style template delimiters, change the
	  // following template settings to use alternative delimiters.
	  _.templateSettings = {
	    evaluate: /<%([\s\S]+?)%>/g,
	    interpolate: /<%=([\s\S]+?)%>/g,
	    escape: /<%-([\s\S]+?)%>/g
	  };

	  // When customizing `templateSettings`, if you don't want to define an
	  // interpolation, evaluation or escaping regex, we need one that is
	  // guaranteed not to match.
	  var noMatch = /(.)^/;

	  // Certain characters need to be escaped so that they can be put into a
	  // string literal.
	  var escapes = {
	    "'": "'",
	    '\\': '\\',
	    '\r': 'r',
	    '\n': 'n',
	    '\u2028': 'u2028',
	    '\u2029': 'u2029'
	  };

	  var escaper = /\\|'|\r|\n|\u2028|\u2029/g;

	  var escapeChar = function escapeChar(match) {
	    return '\\' + escapes[match];
	  };

	  // JavaScript micro-templating, similar to John Resig's implementation.
	  // Underscore templating handles arbitrary delimiters, preserves whitespace,
	  // and correctly escapes quotes within interpolated code.
	  // NB: `oldSettings` only exists for backwards compatibility.
	  _.template = function (text, settings, oldSettings) {
	    if (!settings && oldSettings) settings = oldSettings;
	    settings = _.defaults({}, settings, _.templateSettings);

	    // Combine delimiters into one regular expression via alternation.
	    var matcher = RegExp([(settings.escape || noMatch).source, (settings.interpolate || noMatch).source, (settings.evaluate || noMatch).source].join('|') + '|$', 'g');

	    // Compile the template source, escaping string literals appropriately.
	    var index = 0;
	    var source = "__p+='";
	    text.replace(matcher, function (match, escape, interpolate, evaluate, offset) {
	      source += text.slice(index, offset).replace(escaper, escapeChar);
	      index = offset + match.length;

	      if (escape) {
	        source += "'+\n((__t=(" + escape + "))==null?'':_.escape(__t))+\n'";
	      } else if (interpolate) {
	        source += "'+\n((__t=(" + interpolate + "))==null?'':__t)+\n'";
	      } else if (evaluate) {
	        source += "';\n" + evaluate + "\n__p+='";
	      }

	      // Adobe VMs need the match returned to produce the correct offest.
	      return match;
	    });
	    source += "';\n";

	    // If a variable is not specified, place data values in local scope.
	    if (!settings.variable) source = 'with(obj||{}){\n' + source + '}\n';

	    source = "var __t,__p='',__j=Array.prototype.join," + "print=function(){__p+=__j.call(arguments,'');};\n" + source + 'return __p;\n';

	    try {
	      var render = new Function(settings.variable || 'obj', '_', source);
	    } catch (e) {
	      e.source = source;
	      throw e;
	    }

	    var template = function template(data) {
	      return render.call(this, data, _);
	    };

	    // Provide the compiled source as a convenience for precompilation.
	    var argument = settings.variable || 'obj';
	    template.source = 'function(' + argument + '){\n' + source + '}';

	    return template;
	  };

	  // Add a "chain" function. Start chaining a wrapped Underscore object.
	  _.chain = function (obj) {
	    var instance = _(obj);
	    instance._chain = true;
	    return instance;
	  };

	  // OOP
	  // ---------------
	  // If Underscore is called as a function, it returns a wrapped object that
	  // can be used OO-style. This wrapper holds altered versions of all the
	  // underscore functions. Wrapped objects may be chained.

	  // Helper function to continue chaining intermediate results.
	  var result = function result(instance, obj) {
	    return instance._chain ? _(obj).chain() : obj;
	  };

	  // Add your own custom functions to the Underscore object.
	  _.mixin = function (obj) {
	    _.each(_.functions(obj), function (name) {
	      var func = _[name] = obj[name];
	      _.prototype[name] = function () {
	        var args = [this._wrapped];
	        push.apply(args, arguments);
	        return result(this, func.apply(_, args));
	      };
	    });
	  };

	  // Add all of the Underscore functions to the wrapper object.
	  _.mixin(_);

	  // Add all mutator Array functions to the wrapper.
	  _.each(['pop', 'push', 'reverse', 'shift', 'sort', 'splice', 'unshift'], function (name) {
	    var method = ArrayProto[name];
	    _.prototype[name] = function () {
	      var obj = this._wrapped;
	      method.apply(obj, arguments);
	      if ((name === 'shift' || name === 'splice') && obj.length === 0) delete obj[0];
	      return result(this, obj);
	    };
	  });

	  // Add all accessor Array functions to the wrapper.
	  _.each(['concat', 'join', 'slice'], function (name) {
	    var method = ArrayProto[name];
	    _.prototype[name] = function () {
	      return result(this, method.apply(this._wrapped, arguments));
	    };
	  });

	  // Extracts the result from a wrapped and chained object.
	  _.prototype.value = function () {
	    return this._wrapped;
	  };

	  // Provide unwrapping proxy for some methods used in engine operations
	  // such as arithmetic and JSON stringification.
	  _.prototype.valueOf = _.prototype.toJSON = _.prototype.value;

	  _.prototype.toString = function () {
	    return '' + this._wrapped;
	  };

	  // AMD registration happens at the end for compatibility with AMD loaders
	  // that may not enforce next-turn semantics on modules. Even though general
	  // practice for AMD registration is to be anonymous, underscore registers
	  // as a named module because, like jQuery, it is a base library that is
	  // popular enough to be bundled in a third party lib, but not be part of
	  // an AMD load request. Those cases could generate an error when an
	  // anonymous define() is called outside of a loader request.
	  if (true) {
	    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = function () {
	      return _;
	    }.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	  }
	}).call(undefined);

/***/ },
/* 3 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.Hooks;

/***/ },
/* 4 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.React;

/***/ },
/* 5 */
/***/ function(module, exports) {

	module.exports = MailPoet;

/***/ },
/* 6 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.ReactStringReplace;

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;'use strict';

	!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(3), __webpack_require__(5), __webpack_require__(4), __webpack_require__(8), __webpack_require__(9)], __WEBPACK_AMD_DEFINE_RESULT__ = function (Hooks, MailPoet, React, Router, CampaignStatsPage) {
	  var addCampaignStatsRoute = function addCampaignStatsRoute(routes) {
	    routes.push({
	      path: "stats/:id(/)**",
	      component: CampaignStatsPage
	    });
	    return routes;
	  };

	  Hooks.addFilter('mailpoet_newsletters_before_router', addCampaignStatsRoute);

	  var trackStatsClicked = function trackStatsClicked() {
	    MailPoet.trackEvent('User has clicked to view detailed stats', { 'MailPoet Premium version': window.mailpoet_premium_version });
	  };

	  var addCampaignStatsLink = function addCampaignStatsLink(params, newsletter) {
	    params.link = '/stats/' + newsletter.id;
	    params.onClick = trackStatsClicked;
	    return params;
	  };

	  Hooks.addFilter('mailpoet_newsletters_listing_stats_before', addCampaignStatsLink);

	  var Link = Router.Link;

	  var addStatisticsAction = function addStatisticsAction(actions) {
	    actions.unshift({
	      name: 'stats',
	      link: function link(newsletter) {
	        return React.createElement(
	          Link,
	          { to: '/stats/' + newsletter.id, onClick: trackStatsClicked },
	          MailPoet.I18n.t('statsListingActionTitle')
	        );
	      },
	      display: function display(newsletter) {
	        // welcome emails provide explicit total_sent value
	        var count_processed = newsletter.queue && newsletter.queue.count_processed;
	        return ~ ~(newsletter.total_sent || count_processed) > 0;
	      }
	    });
	    return actions;
	  };

	  Hooks.addFilter('mailpoet_newsletters_listings_standard_actions', addStatisticsAction);
	  Hooks.addFilter('mailpoet_newsletters_listings_welcome_notification_actions', addStatisticsAction);
	  Hooks.addFilter('mailpoet_newsletters_listings_notification_history_actions', addStatisticsAction);
	}.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ },
/* 8 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.ReactRouter;

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _reactRouter = __webpack_require__(8);

	var _reactStringReplace = __webpack_require__(6);

	var _reactStringReplace2 = _interopRequireDefault(_reactStringReplace);

	var _newsletter_statsJsx = __webpack_require__(10);

	var _newsletter_statsJsx2 = _interopRequireDefault(_newsletter_statsJsx);

	var _newsletter_infoJsx = __webpack_require__(12);

	var _newsletter_infoJsx2 = _interopRequireDefault(_newsletter_infoJsx);

	var _clicked_links_tableJsx = __webpack_require__(13);

	var _clicked_links_tableJsx2 = _interopRequireDefault(_clicked_links_tableJsx);

	var _subscriber_engagementJsx = __webpack_require__(14);

	var _subscriber_engagementJsx2 = _interopRequireDefault(_subscriber_engagementJsx);

	var CampaignStatsPage = (function (_React$Component) {
	  _inherits(CampaignStatsPage, _React$Component);

	  function CampaignStatsPage(props) {
	    _classCallCheck(this, CampaignStatsPage);

	    _get(Object.getPrototypeOf(CampaignStatsPage.prototype), 'constructor', this).call(this, props);
	    this.state = {
	      item: {},
	      loading: true,
	      savingSegment: false,
	      segmentCreated: false,
	      segmentErrors: []
	    };
	    this.handleCreateSegment = this.handleCreateSegment.bind(this);
	  }

	  _createClass(CampaignStatsPage, [{
	    key: 'handleCreateSegment',
	    value: function handleCreateSegment(group, newsletter, linkId) {
	      var _this = this;

	      var name = newsletter.subject + ' – ' + group;
	      this.setState({ savingSegment: true, segmentCreated: false, segmentErrors: [] });
	      _mailpoet2['default'].Ajax.post({
	        api_version: window.mailpoet_api_version,
	        endpoint: 'dynamic_segments',
	        action: 'save',
	        data: {
	          segmentType: 'email',
	          action: group === 'unopened' ? 'notOpened' : group,
	          newsletter_id: newsletter.id,
	          link_id: linkId,
	          name: name
	        }
	      }).always(function () {
	        _this.setState({ savingSegment: false });
	      }).done(function () {
	        _this.setState({
	          segmentCreated: true,
	          segmentName: name
	        });
	      }).fail(function (response) {
	        _this.setState({
	          segmentErrors: response.errors.map(function (error) {
	            return error.error === 409 ? _mailpoet2['default'].I18n.t('segmentExists') : error.message;
	          })
	        });
	      });
	    }
	  }, {
	    key: 'componentDidMount',
	    value: function componentDidMount() {
	      // Scroll to top in case we're coming
	      // from the middle of a long newsletter listing
	      window.scrollTo(0, 0);
	      this.loadItem(this.props.params.id);
	    }
	  }, {
	    key: 'componentWillReceiveProps',
	    value: function componentWillReceiveProps(props) {
	      if (this.props.params.id !== props.params.id) {
	        this.loadItem(props.params.id);
	      }
	    }
	  }, {
	    key: 'loadItem',
	    value: function loadItem(id) {
	      var _this2 = this;

	      this.setState({ loading: true });
	      _mailpoet2['default'].Modal.loading(true);

	      _mailpoet2['default'].Ajax.post({
	        api_version: window.mailpoet_api_version,
	        endpoint: 'stats',
	        action: 'get',
	        data: {
	          id: id
	        }
	      }).always(function (response) {
	        _mailpoet2['default'].Modal.loading(false);
	      }).done(function (response) {
	        _this2.setState({
	          loading: false,
	          item: response.data
	        });
	      }).fail(function (response) {
	        _mailpoet2['default'].Notice.error(response.errors.map(function (error) {
	          return error.message;
	        }), { scroll: true });
	        _this2.setState({
	          loading: false,
	          item: {}
	        }, function () {
	          _this2.context.router.push('/');
	        });
	      });
	    }
	  }, {
	    key: 'renderCreateSegmentSuccess',
	    value: function renderCreateSegmentSuccess() {
	      var _this3 = this;

	      var segmentCreatedSuccessMessage = undefined;

	      if (this.state.segmentCreated) {
	        var message = (0, _reactStringReplace2['default'])(_mailpoet2['default'].I18n.t('successMessage'), /\[link\](.*?)\[\/link\]/g, function (match, i) {
	          return _react2['default'].createElement(
	            'a',
	            {
	              key: i,
	              href: '?page=mailpoet-newsletters#/new'
	            },
	            match
	          );
	        });

	        message = (0, _reactStringReplace2['default'])(message, '%s', function () {
	          return _this3.state.segmentName;
	        });

	        segmentCreatedSuccessMessage = _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_notice notice inline notice-success' },
	          _react2['default'].createElement(
	            'p',
	            null,
	            message
	          )
	        );
	      }

	      return segmentCreatedSuccessMessage;
	    }
	  }, {
	    key: 'renderCreateSegmentError',
	    value: function renderCreateSegmentError() {
	      var error = undefined;

	      if (this.state.segmentErrors.length > 0) {
	        error = _react2['default'].createElement(
	          'div',
	          null,
	          this.state.segmentErrors.map(function (errorMessage, i) {
	            return _react2['default'].createElement(
	              'div',
	              { className: 'mailpoet_notice notice inline error', key: 'error-' + i },
	              _react2['default'].createElement(
	                'p',
	                null,
	                errorMessage
	              )
	            );
	          })
	        );
	      }

	      return error;
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      var newsletter = this.state.item;

	      if (this.state.loading || !newsletter.queue) {
	        return _react2['default'].createElement(
	          'div',
	          null,
	          _react2['default'].createElement(
	            'h1',
	            { className: 'title' },
	            _mailpoet2['default'].I18n.t('statsTitle'),
	            _react2['default'].createElement(
	              _reactRouter.Link,
	              {
	                className: 'page-title-action',
	                to: '/'
	              },
	              _mailpoet2['default'].I18n.t('backToList')
	            )
	          )
	        );
	      }

	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'h1',
	          { className: 'title' },
	          _mailpoet2['default'].I18n.t('statsTitle'),
	          ': ',
	          newsletter.subject,
	          _react2['default'].createElement(
	            _reactRouter.Link,
	            {
	              className: 'page-title-action',
	              to: '/'
	            },
	            _mailpoet2['default'].I18n.t('backToList')
	          )
	        ),
	        _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_stat_triple-spaced' },
	          _react2['default'].createElement(
	            'div',
	            { style: { width: '40%', 'float': 'right' } },
	            _react2['default'].createElement(_newsletter_infoJsx2['default'], { newsletter: newsletter })
	          ),
	          _react2['default'].createElement(
	            'div',
	            { style: { width: '60%' } },
	            _react2['default'].createElement(_newsletter_statsJsx2['default'], { newsletter: newsletter })
	          ),
	          _react2['default'].createElement('div', { style: { clear: 'both' } })
	        ),
	        _react2['default'].createElement(
	          'h2',
	          null,
	          _mailpoet2['default'].I18n.t('clickedLinks')
	        ),
	        _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_stat_triple-spaced' },
	          _react2['default'].createElement(_clicked_links_tableJsx2['default'], { links: newsletter.clicked_links })
	        ),
	        _react2['default'].createElement(
	          'h2',
	          null,
	          _mailpoet2['default'].I18n.t('subscriberEngagement')
	        ),
	        this.renderCreateSegmentSuccess(),
	        this.renderCreateSegmentError(),
	        _react2['default'].createElement(_subscriber_engagementJsx2['default'], {
	          location: this.props.location,
	          params: this.props.params,
	          newsletter: newsletter,
	          handleCreateSegment: this.handleCreateSegment,
	          savingSegment: this.state.savingSegment
	        })
	      );
	    }
	  }]);

	  return CampaignStatsPage;
	})(_react2['default'].Component);

	CampaignStatsPage.contextTypes = {
	  router: _react2['default'].PropTypes.object.isRequired
	};

	exports['default'] = CampaignStatsPage;
	module.exports = exports['default'];

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _statsBadge = __webpack_require__(11);

	var _statsBadge2 = _interopRequireDefault(_statsBadge);

	var NewsletterGeneralStats = (function (_React$Component) {
	  _inherits(NewsletterGeneralStats, _React$Component);

	  function NewsletterGeneralStats() {
	    _classCallCheck(this, NewsletterGeneralStats);

	    _get(Object.getPrototypeOf(NewsletterGeneralStats.prototype), 'constructor', this).apply(this, arguments);
	  }

	  _createClass(NewsletterGeneralStats, [{
	    key: 'render',
	    value: function render() {
	      var newsletter = this.props.newsletter;

	      var total_sent = newsletter.total_sent || 0;

	      var percentage_clicked = 0;
	      var percentage_opened = 0;
	      var percentage_unsubscribed = 0;

	      if (total_sent > 0) {
	        percentage_clicked = newsletter.statistics.clicked * 100 / total_sent;
	        percentage_opened = newsletter.statistics.opened * 100 / total_sent;
	        percentage_unsubscribed = newsletter.statistics.unsubscribed * 100 / total_sent;
	      }

	      // format to 1 decimal place
	      var percentage_clicked_display = _mailpoet2['default'].Num.toLocaleFixed(percentage_clicked, 1);
	      var percentage_opened_display = _mailpoet2['default'].Num.toLocaleFixed(percentage_opened, 1);
	      var percentage_unsubscribed_display = _mailpoet2['default'].Num.toLocaleFixed(percentage_unsubscribed, 1);

	      var headline_opened = percentage_opened_display + '% ' + _mailpoet2['default'].I18n.t('percentageOpened');
	      var headline_clicked = percentage_clicked_display + '% ' + _mailpoet2['default'].I18n.t('percentageClicked');
	      var headline_unsubscribed = percentage_unsubscribed_display + '% ' + _mailpoet2['default'].I18n.t('percentageUnsubscribed');

	      var statsKBLink = 'http://beta.docs.mailpoet.com/article/190-whats-a-good-email-open-rate';

	      // thresholds to display badges
	      var min_newsletters_sent = 20;
	      var min_newsletter_opens = 5;

	      var stats_content = undefined;
	      if (total_sent >= min_newsletters_sent && newsletter.statistics.opened >= min_newsletter_opens) {
	        // display stats with badges
	        stats_content = _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_stat_grey' },
	          _react2['default'].createElement(
	            'div',
	            { className: 'mailpoet_stat_big mailpoet_stat_spaced' },
	            _react2['default'].createElement(_statsBadge2['default'], {
	              stat: 'opened',
	              rate: percentage_opened,
	              headline: headline_opened
	            })
	          ),
	          _react2['default'].createElement(
	            'div',
	            { className: 'mailpoet_stat_big mailpoet_stat_spaced' },
	            _react2['default'].createElement(_statsBadge2['default'], {
	              stat: 'clicked',
	              rate: percentage_clicked,
	              headline: headline_clicked
	            })
	          ),
	          _react2['default'].createElement(
	            'div',
	            null,
	            _react2['default'].createElement(_statsBadge2['default'], {
	              stat: 'unsubscribed',
	              rate: percentage_unsubscribed,
	              headline: headline_unsubscribed
	            })
	          )
	        );
	      } else {
	        // display stats without badges
	        stats_content = _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_stat_grey' },
	          _react2['default'].createElement(
	            'div',
	            { className: 'mailpoet_stat_big mailpoet_stat_spaced' },
	            headline_opened
	          ),
	          _react2['default'].createElement(
	            'div',
	            { className: 'mailpoet_stat_big mailpoet_stat_spaced' },
	            headline_clicked
	          ),
	          _react2['default'].createElement(
	            'div',
	            null,
	            headline_unsubscribed
	          )
	        );
	      }

	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'p',
	          { className: 'mailpoet_stat_grey mailpoet_stat_big' },
	          _mailpoet2['default'].I18n.t('statsTotalSent'),
	          ' ',
	          parseInt(total_sent, 10).toLocaleString()
	        ),
	        stats_content,
	        newsletter.ga_campaign && _react2['default'].createElement(
	          'p',
	          null,
	          _mailpoet2['default'].I18n.t('googleAnalytics'),
	          ': ',
	          newsletter.ga_campaign
	        ),
	        _react2['default'].createElement(
	          'p',
	          null,
	          _react2['default'].createElement(
	            'a',
	            { href: statsKBLink, target: '_blank' },
	            _mailpoet2['default'].I18n.t('readMoreOnStats')
	          )
	        )
	      );
	    }
	  }]);

	  return NewsletterGeneralStats;
	})(_react2['default'].Component);

	NewsletterGeneralStats.propTypes = {
	  newsletter: _react2['default'].PropTypes.object.isRequired
	};

	exports['default'] = NewsletterGeneralStats;
	module.exports = exports['default'];

/***/ },
/* 11 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.StatsBadge;

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var NewsletterStatsInfo = (function (_React$Component) {
	  _inherits(NewsletterStatsInfo, _React$Component);

	  function NewsletterStatsInfo() {
	    _classCallCheck(this, NewsletterStatsInfo);

	    _get(Object.getPrototypeOf(NewsletterStatsInfo.prototype), 'constructor', this).apply(this, arguments);
	  }

	  _createClass(NewsletterStatsInfo, [{
	    key: 'formatAddress',
	    value: function formatAddress(address, name) {
	      var addressString = '';
	      if (address) {
	        addressString = name ? name + ' <' + address + '>' : address;
	      }
	      return addressString;
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      var newsletter = this.props.newsletter;

	      var newsletter_date = newsletter.queue.scheduled_at || newsletter.queue.created_at;

	      var sender_address = this.formatAddress(newsletter.sender_address || '', newsletter.sender_name || '');
	      var reply_to_address = this.formatAddress(newsletter.reply_to_address || '', newsletter.reply_to_name || '');

	      var segments = (newsletter.segments || []).map(function (segment) {
	        return segment.name;
	      }).join(', ');

	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'div',
	          { className: 'mailpoet_stat_spaced' },
	          _react2['default'].createElement(
	            'a',
	            { href: newsletter.preview_url, className: 'button-secondary', target: '_blank' },
	            _mailpoet2['default'].I18n.t('statsPreviewNewsletter')
	          )
	        ),
	        _react2['default'].createElement(
	          'p',
	          null,
	          _mailpoet2['default'].I18n.t('statsDateSent'),
	          ': ',
	          _mailpoet2['default'].Date.format(newsletter_date)
	        ),
	        segments && _react2['default'].createElement(
	          'p',
	          null,
	          _mailpoet2['default'].I18n.t('statsToSegments'),
	          ': ',
	          segments
	        ),
	        _react2['default'].createElement(
	          'p',
	          null,
	          _mailpoet2['default'].I18n.t('statsFromAddress'),
	          ': ',
	          sender_address
	        ),
	        reply_to_address && _react2['default'].createElement(
	          'p',
	          null,
	          _mailpoet2['default'].I18n.t('statsReplyToAddress'),
	          ': ',
	          reply_to_address
	        )
	      );
	    }
	  }]);

	  return NewsletterStatsInfo;
	})(_react2['default'].Component);

	NewsletterStatsInfo.propTypes = {
	  newsletter: _react2['default'].PropTypes.object.isRequired
	};

	exports['default'] = NewsletterStatsInfo;
	module.exports = exports['default'];

/***/ },
/* 13 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var ClickedLinksTable = (function (_React$Component) {
	  _inherits(ClickedLinksTable, _React$Component);

	  function ClickedLinksTable() {
	    _classCallCheck(this, ClickedLinksTable);

	    _get(Object.getPrototypeOf(ClickedLinksTable.prototype), 'constructor', this).apply(this, arguments);
	  }

	  _createClass(ClickedLinksTable, [{
	    key: 'renderLink',
	    value: function renderLink(url) {
	      if (mailpoet_shortcode_links[url]) {
	        return mailpoet_shortcode_links[url];
	      }
	      return _react2['default'].createElement(
	        'a',
	        { href: url, target: '_blank' },
	        url
	      );
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      var _this = this;

	      var links = this.props.links;

	      var content = undefined;
	      if (links.length === 0) {
	        content = _react2['default'].createElement(
	          'tr',
	          { className: 'alternate' },
	          _react2['default'].createElement(
	            'td',
	            { colSpan: '2' },
	            _mailpoet2['default'].I18n.t('noClickedLinksFound')
	          )
	        );
	      } else {
	        content = links.map(function (row, index) {
	          return _react2['default'].createElement(
	            'tr',
	            {
	              key: 'link-' + index,
	              className: index & 1 ? 'alternate' : ''
	            },
	            _react2['default'].createElement(
	              'td',
	              null,
	              _this.renderLink(row.url)
	            ),
	            _react2['default'].createElement(
	              'td',
	              null,
	              row.cnt
	            )
	          );
	        });
	      }

	      return _react2['default'].createElement(
	        'table',
	        { className: 'widefat' },
	        _react2['default'].createElement(
	          'thead',
	          null,
	          _react2['default'].createElement(
	            'tr',
	            null,
	            _react2['default'].createElement(
	              'td',
	              null,
	              _mailpoet2['default'].I18n.t('linkColumn')
	            ),
	            _react2['default'].createElement(
	              'td',
	              null,
	              _mailpoet2['default'].I18n.t('uniqueClicksColumn')
	            )
	          )
	        ),
	        _react2['default'].createElement(
	          'tbody',
	          null,
	          content
	        )
	      );
	    }
	  }]);

	  return ClickedLinksTable;
	})(_react2['default'].Component);

	exports['default'] = ClickedLinksTable;
	module.exports = exports['default'];

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _underscore = __webpack_require__(2);

	var _underscore2 = _interopRequireDefault(_underscore);

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _listing = __webpack_require__(15);

	var _listing2 = _interopRequireDefault(_listing);

	var columns = [{
	  name: 'email',
	  label: _mailpoet2['default'].I18n.t('subscriberColumn'),
	  sortable: true
	}, {
	  name: 'status',
	  label: _mailpoet2['default'].I18n.t('statusColumn'),
	  sortable: true
	}, {
	  name: 'created_at',
	  label: _mailpoet2['default'].I18n.t('dateAndTimeColumn'),
	  sortable: true
	}];

	var messages = {
	  onLoadingItems: function onLoadingItems() {
	    return _mailpoet2['default'].I18n.t('loadingEngagementItems');
	  },
	  onNoItemsFound: function onNoItemsFound() {
	    return _mailpoet2['default'].I18n.t('noEngagementItemsFound');
	  }
	};

	// Track once per page load
	var trackFilteredByClickedLinks = _underscore2['default'].once(function () {
	  _mailpoet2['default'].trackEvent('User has filtered subscribers by clicked links', { 'MailPoet Premium version': window.mailpoet_premium_version });
	});

	var SubscriberEngagementListing = (function (_React$Component) {
	  _inherits(SubscriberEngagementListing, _React$Component);

	  function SubscriberEngagementListing(props) {
	    _classCallCheck(this, SubscriberEngagementListing);

	    _get(Object.getPrototypeOf(SubscriberEngagementListing.prototype), 'constructor', this).call(this, props);
	    this.renderCreateSegmentButton = this.renderCreateSegmentButton.bind(this);
	    this.handleCreateSegment = this.handleCreateSegment.bind(this);
	  }

	  _createClass(SubscriberEngagementListing, [{
	    key: 'handleCreateSegment',
	    value: function handleCreateSegment(group, newsletter, linkId) {
	      this.props.handleCreateSegment(group, newsletter, linkId);
	    }
	  }, {
	    key: 'renderCreateSegmentButton',
	    value: function renderCreateSegmentButton(listingState) {
	      if (['opened', 'clicked', 'unopened'].indexOf(listingState.group) !== -1) {
	        return _react2['default'].createElement('input', {
	          onClick: _underscore2['default'].partial(this.handleCreateSegment, listingState.group, this.props.newsletter, listingState.filter.link),
	          type: 'submit',
	          value: this.props.savingSegment ? _mailpoet2['default'].I18n.t('savingSegment') : _mailpoet2['default'].I18n.t('createSegment'),
	          className: 'stats-create-segment button',
	          disabled: this.props.savingSegment
	        });
	      }
	      return undefined;
	    }
	  }, {
	    key: 'renderStatItem',
	    value: function renderStatItem(statistic, actions) {
	      var status = '';

	      switch (statistic.status) {
	        case 'opened':
	          status = _mailpoet2['default'].I18n.t('opened');
	          break;

	        case 'clicked':
	          status = _mailpoet2['default'].I18n.t('clicked');
	          break;

	        case 'unsubscribed':
	          status = _mailpoet2['default'].I18n.t('unsubscribed');
	          break;

	        case 'unopened':
	          status = _mailpoet2['default'].I18n.t('unopened');
	          break;
	      }

	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'td',
	          { className: 'manage-column column-primary has-row-actions' },
	          _react2['default'].createElement(
	            'strong',
	            null,
	            _react2['default'].createElement(
	              'a',
	              {
	                className: 'row-title',
	                href: statistic.subscriber_url
	              },
	              statistic.email
	            )
	          ),
	          _react2['default'].createElement(
	            'p',
	            { style: { margin: 0 } },
	            statistic.first_name,
	            ' ',
	            statistic.last_name
	          )
	        ),
	        _react2['default'].createElement(
	          'td',
	          { className: 'column', 'data-colname': _mailpoet2['default'].I18n.t('statusColumn') },
	          status
	        ),
	        _react2['default'].createElement(
	          'td',
	          { className: 'column-date', 'data-colname': _mailpoet2['default'].I18n.t('dateAndTimeColumn') },
	          _react2['default'].createElement(
	            'abbr',
	            null,
	            _mailpoet2['default'].Date.format(statistic.created_at)
	          )
	        )
	      );
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      return _react2['default'].createElement(_listing2['default'], {
	        limit: mailpoet_listing_per_page,
	        location: this.props.location,
	        params: this.props.params,
	        endpoint: 'stats',
	        base_url: 'stats/:id',
	        onRenderItem: this.renderStatItem,
	        onBeforeSelectFilter: trackFilteredByClickedLinks,
	        columns: columns,
	        messages: messages,
	        sort_by: 'created_at',
	        sort_order: 'desc',
	        renderExtraActions: this.renderCreateSegmentButton
	      });
	    }
	  }]);

	  return SubscriberEngagementListing;
	})(_react2['default'].Component);

	exports['default'] = SubscriberEngagementListing;
	module.exports = exports['default'];

/***/ },
/* 15 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.Listing;

/***/ },
/* 16 */
/***/ function(module, exports, __webpack_require__) {

	var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;'use strict';

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	var _newslettersWelcome_notificationWelcomeJsx = __webpack_require__(17);

	var _newslettersWelcome_notificationWelcomeJsx2 = _interopRequireDefault(_newslettersWelcome_notificationWelcomeJsx);

	!(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(3), __webpack_require__(4), __webpack_require__(5)], __WEBPACK_AMD_DEFINE_RESULT__ = function (Hooks, React, MailPoet) {
	  var addWelcomeNotificationNewsletterType = function addWelcomeNotificationNewsletterType(types, that) {
	    types = types.map(function (type) {
	      if (type.slug !== 'welcome') return type;

	      type.action = (function () {
	        return React.createElement(
	          'a',
	          { className: 'button button-primary', onClick: that.setupNewsletter.bind(null, type.slug) },
	          MailPoet.I18n.t('setUp')
	        );
	      }).bind(this)();
	      return type;
	    });
	    return types;
	  };

	  Hooks.addFilter('mailpoet_newsletters_types', addWelcomeNotificationNewsletterType);

	  var addWelcomeNotificationNewsletterTypeRoute = function addWelcomeNotificationNewsletterTypeRoute(routes) {
	    routes.push({
	      path: "new/welcome",
	      component: _newslettersWelcome_notificationWelcomeJsx2['default']
	    });
	    return routes;
	  };

	  Hooks.addFilter('mailpoet_newsletters_before_router', addWelcomeNotificationNewsletterTypeRoute);

	  var addListingsWelcomeNotificationAction = function addListingsWelcomeNotificationAction(actions) {
	    actions.push({
	      name: 'duplicate',
	      label: MailPoet.I18n.t('duplicate'),
	      onClick: function onClick(newsletter, refresh) {
	        return MailPoet.Ajax.post({
	          api_version: window.mailpoet_api_version,
	          endpoint: 'newsletters',
	          action: 'duplicate',
	          data: {
	            id: newsletter.id
	          }
	        }).done(function (response) {
	          MailPoet.Notice.success(MailPoet.I18n.t('newsletterDuplicated').replace('%$1s', response.data.subject));
	          refresh();
	        }).fail(function (response) {
	          if (response.errors.length > 0) {
	            MailPoet.Notice.error(response.errors.map(function (error) {
	              return error.message;
	            }), { scroll: true });
	          }
	        });
	      }
	    });
	    return actions;
	  };

	  Hooks.addFilter('mailpoet_newsletters_listings_welcome_notification_actions', addListingsWelcomeNotificationAction);
	}.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__), __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ },
/* 17 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, '__esModule', {
	  value: true
	});

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _underscore = __webpack_require__(2);

	var _underscore2 = _interopRequireDefault(_underscore);

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _newsletterWelcomeNotificationScheduling = __webpack_require__(18);

	var _newsletterWelcomeNotificationScheduling2 = _interopRequireDefault(_newsletterWelcomeNotificationScheduling);

	var _newsletterCreationBreadcrumb = __webpack_require__(19);

	var _newsletterCreationBreadcrumb2 = _interopRequireDefault(_newsletterCreationBreadcrumb);

	var field = {
	  name: 'options',
	  label: 'Event',
	  type: 'reactComponent',
	  component: _newsletterWelcomeNotificationScheduling2['default']
	};

	var NewsletterWelcome = (function (_React$Component) {
	  _inherits(NewsletterWelcome, _React$Component);

	  function NewsletterWelcome(props) {
	    _classCallCheck(this, NewsletterWelcome);

	    _get(Object.getPrototypeOf(NewsletterWelcome.prototype), 'constructor', this).call(this, props);
	    var availableSegments = window.mailpoet_segments || [];
	    var defaultSegment = 1;
	    availableSegments = availableSegments.filter(function (segment) {
	      return segment.type === 'default';
	    });

	    if (_underscore2['default'].size(availableSegments) > 0) {
	      defaultSegment = _underscore2['default'].first(availableSegments).id;
	    }

	    this.state = {
	      options: {
	        event: 'segment',
	        segment: defaultSegment,
	        role: 'subscriber',
	        afterTimeNumber: 1,
	        afterTimeType: 'immediate'
	      }
	    };

	    this.handleValueChange = this.handleValueChange.bind(this);
	    this.handleNext = this.handleNext.bind(this);
	  }

	  _createClass(NewsletterWelcome, [{
	    key: 'handleValueChange',
	    value: function handleValueChange(event) {
	      var state = this.state;
	      state[event.target.name] = event.target.value;
	      this.setState(state);
	    }
	  }, {
	    key: 'handleNext',
	    value: function handleNext() {
	      var _this = this;

	      _mailpoet2['default'].Ajax.post({
	        api_version: window.mailpoet_api_version,
	        endpoint: 'newsletters',
	        action: 'create',
	        data: _underscore2['default'].extend({}, this.state, {
	          type: 'welcome',
	          subject: _mailpoet2['default'].I18n.t('draftNewsletterTitle')
	        })
	      }).done(function (response) {
	        _this.showTemplateSelection(response.data.id);
	      }).fail(function (response) {
	        if (response.errors.length > 0) {
	          _mailpoet2['default'].Notice.error(response.errors.map(function (error) {
	            return error.message;
	          }), { scroll: true });
	        }
	      });
	    }
	  }, {
	    key: 'showTemplateSelection',
	    value: function showTemplateSelection(newsletterId) {
	      this.props.router.push('/template/' + newsletterId);
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'h1',
	          null,
	          _mailpoet2['default'].I18n.t('welcomeNewsletterTypeTitle')
	        ),
	        _react2['default'].createElement(_newsletterCreationBreadcrumb2['default'], { step: 'type' }),
	        _react2['default'].createElement(
	          'h3',
	          null,
	          _mailpoet2['default'].I18n.t('selectEventToSendWelcomeEmail')
	        ),
	        _react2['default'].createElement(_newsletterWelcomeNotificationScheduling2['default'], {
	          item: this.state,
	          field: field,
	          onValueChange: this.handleValueChange }),
	        _react2['default'].createElement(
	          'p',
	          { className: 'submit' },
	          _react2['default'].createElement('input', {
	            className: 'button button-primary',
	            type: 'button',
	            onClick: this.handleNext,
	            value: _mailpoet2['default'].I18n.t('next') })
	        )
	      );
	    }
	  }]);

	  return NewsletterWelcome;
	})(_react2['default'].Component);

	exports['default'] = NewsletterWelcome;
	module.exports = exports['default'];

/***/ },
/* 18 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.NewsletterWelcomeNotificationScheduling;

/***/ },
/* 19 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.NewsletterCreationBreadcrumb;

/***/ },
/* 20 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _reactDom = __webpack_require__(21);

	var _reactDom2 = _interopRequireDefault(_reactDom);

	var _reactRouter = __webpack_require__(8);

	var _listJsx = __webpack_require__(22);

	var _listJsx2 = _interopRequireDefault(_listJsx);

	var _formJsx = __webpack_require__(23);

	var _formJsx2 = _interopRequireDefault(_formJsx);

	// import doesn't work here :( babel with webpack use history['default'] which is undefined

	var _require = __webpack_require__(28);

	var createHashHistory = _require.createHashHistory;

	var history = (0, _reactRouter.useRouterHistory)(createHashHistory)({ queryKey: false });

	var App = _react2['default'].createClass({
	  displayName: 'App',

	  render: function render() {
	    return this.props.children;
	  }
	});

	var container = document.getElementById('dynamic_segments_container');

	if (container) {
	  _reactDom2['default'].render(_react2['default'].createElement(
	    _reactRouter.Router,
	    { history: history },
	    _react2['default'].createElement(
	      _reactRouter.Route,
	      { path: '/', component: App },
	      _react2['default'].createElement(_reactRouter.IndexRoute, { component: _listJsx2['default'] }),
	      _react2['default'].createElement(_reactRouter.Route, { path: 'new', component: _formJsx2['default'] }),
	      _react2['default'].createElement(_reactRouter.Route, { path: 'edit/:id', component: _formJsx2['default'] }),
	      _react2['default'].createElement(_reactRouter.Route, { path: '*', component: _listJsx2['default'] })
	    )
	  ), container);
	}

/***/ },
/* 21 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.ReactDOM;

/***/ },
/* 22 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _reactRouter = __webpack_require__(8);

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _listing = __webpack_require__(15);

	var _listing2 = _interopRequireDefault(_listing);

	var columns = [{
	  name: 'name',
	  label: _mailpoet2['default'].I18n.t('nameColumn'),
	  sortable: true
	}, {
	  name: 'count',
	  label: _mailpoet2['default'].I18n.t('subscribersCountColumn'),
	  sortable: false
	}, {
	  name: 'updated_at',
	  label: _mailpoet2['default'].I18n.t('updatedAtColumn'),
	  sortable: true
	}];

	var messages = {
	  onLoadingItems: function onLoadingItems() {
	    return _mailpoet2['default'].I18n.t('loadingDynamicSegmentItems');
	  },
	  onNoItemsFound: function onNoItemsFound() {
	    return _mailpoet2['default'].I18n.t('noDynamicSegmentItemsFound');
	  },
	  onTrash: function onTrash(response) {
	    var count = Number(response.meta.count);
	    var message = null;

	    if (count === 1) {
	      message = _mailpoet2['default'].I18n.t('oneSegmentTrashed');
	    } else {
	      message = _mailpoet2['default'].I18n.t('multipleSegmentsTrashed').replace('%$1d', count.toLocaleString());
	    }
	    _mailpoet2['default'].Notice.success(message);
	  },
	  onDelete: function onDelete(response) {
	    var count = Number(response.meta.count);
	    var message = null;

	    if (count === 1) {
	      message = _mailpoet2['default'].I18n.t('oneSegmentDeleted');
	    } else {
	      message = _mailpoet2['default'].I18n.t('multipleSegmentsDeleted').replace('%$1d', count.toLocaleString());
	    }
	    _mailpoet2['default'].Notice.success(message);
	  },
	  onRestore: function onRestore(response) {
	    var count = Number(response.meta.count);
	    var message = null;

	    if (count === 1) {
	      message = _mailpoet2['default'].I18n.t('oneSegmentRestored');
	    } else {
	      message = _mailpoet2['default'].I18n.t('multipleSegmentsRestored').replace('%$1d', count.toLocaleString());
	    }
	    _mailpoet2['default'].Notice.success(message);
	  }
	};

	var itemActions = [{
	  name: 'edit',
	  link: function link(item) {
	    return _react2['default'].createElement(
	      _reactRouter.Link,
	      { to: '/edit/' + item.id },
	      _mailpoet2['default'].I18n.t('edit')
	    );
	  }
	}, {
	  name: 'view_subscribers',
	  link: function link(item) {
	    return _react2['default'].createElement(
	      'a',
	      { href: item.subscribers_url },
	      _mailpoet2['default'].I18n.t('viewSubscribers')
	    );
	  }
	}, {
	  name: 'trash'
	}];

	var DynamicSegmentList = (function (_React$Component) {
	  _inherits(DynamicSegmentList, _React$Component);

	  function DynamicSegmentList() {
	    _classCallCheck(this, DynamicSegmentList);

	    _get(Object.getPrototypeOf(DynamicSegmentList.prototype), 'constructor', this).apply(this, arguments);
	  }

	  _createClass(DynamicSegmentList, [{
	    key: 'renderItem',
	    value: function renderItem(item, actions) {
	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'td',
	          { 'data-colname': _mailpoet2['default'].I18n.t('nameColumn') },
	          _react2['default'].createElement(
	            'strong',
	            null,
	            item.name
	          ),
	          actions
	        ),
	        _react2['default'].createElement(
	          'td',
	          { className: 'column', 'data-colname': _mailpoet2['default'].I18n.t('subscribersCountColumn') },
	          item.count
	        ),
	        _react2['default'].createElement(
	          'td',
	          { className: 'column', 'data-colname': _mailpoet2['default'].I18n.t('updatedAtColumn') },
	          _mailpoet2['default'].Date.format(item.updated_at)
	        )
	      );
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'h1',
	          { className: 'title' },
	          _mailpoet2['default'].I18n.t('pageTitle'),
	          ' ',
	          _react2['default'].createElement(
	            _reactRouter.Link,
	            { className: 'page-title-action', to: '/new' },
	            _mailpoet2['default'].I18n.t('new')
	          )
	        ),
	        _react2['default'].createElement(_listing2['default'], {
	          limit: window.mailpoet_listing_per_page,
	          location: this.props.location,
	          params: this.props.params,
	          search: true,
	          onRenderItem: this.renderItem,
	          endpoint: 'dynamic_segments',
	          columns: columns,
	          messages: messages,
	          sort_by: 'created_at',
	          sort_order: 'desc',
	          item_actions: itemActions
	        }),
	        _react2['default'].createElement(
	          'div',
	          null,
	          _react2['default'].createElement(
	            'p',
	            { className: 'mailpoet_sending_methods_help help' },
	            _react2['default'].createElement(
	              'b',
	              null,
	              _mailpoet2['default'].I18n.t('segmentsTip'),
	              ':'
	            ),
	            ' ',
	            _mailpoet2['default'].I18n.t('segmentsTipText'),
	            ' ',
	            _react2['default'].createElement(
	              'a',
	              {
	                href: 'http://beta.docs.mailpoet.com/article/237-guide-to-subscriber-segmentation?utm_source=plugin&utm_medium=segments&utm_campaign=helpdocs',
	                target: '_blank'
	              },
	              _mailpoet2['default'].I18n.t('segmentsTipLink')
	            )
	          )
	        )
	      );
	    }
	  }]);

	  return DynamicSegmentList;
	})(_react2['default'].Component);

	module.exports = DynamicSegmentList;

/***/ },
/* 23 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

	var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) arr2[i] = arr[i]; return arr2; } else { return Array.from(arr); } }

	function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

	function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

	var _react = __webpack_require__(4);

	var _react2 = _interopRequireDefault(_react);

	var _underscore = __webpack_require__(2);

	var _underscore2 = _interopRequireDefault(_underscore);

	var _reactRouter = __webpack_require__(8);

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _form = __webpack_require__(24);

	var _form2 = _interopRequireDefault(_form);

	var _filtersWordpress_role = __webpack_require__(25);

	var _filtersWordpress_role2 = _interopRequireDefault(_filtersWordpress_role);

	var _filtersEmail = __webpack_require__(26);

	var _filtersEmail2 = _interopRequireDefault(_filtersEmail);

	var _filtersWoocommerce = __webpack_require__(27);

	var _filtersWoocommerce2 = _interopRequireDefault(_filtersWoocommerce);

	var messages = {
	  onUpdate: function onUpdate() {
	    _mailpoet2['default'].Notice.success(_mailpoet2['default'].I18n.t('segmentUpdated'));
	  },
	  onCreate: function onCreate(data) {
	    _mailpoet2['default'].Notice.success(_mailpoet2['default'].I18n.t('segmentAdded'));
	    _mailpoet2['default'].trackEvent('Segments > Add new', {
	      'MailPoet Free version': window.mailpoet_version,
	      type: data.segmentType || 'unknown type',
	      subtype: data.action || data.wordpressRole || 'unknown subtype'
	    });
	  }
	};

	var DynamicSegmentForm = (function (_React$Component) {
	  _inherits(DynamicSegmentForm, _React$Component);

	  function DynamicSegmentForm(props) {
	    _classCallCheck(this, DynamicSegmentForm);

	    _get(Object.getPrototypeOf(DynamicSegmentForm.prototype), 'constructor', this).call(this, props);
	    this.state = {
	      item: {
	        segmentType: 'email'
	      },
	      childFields: [],
	      loading: false,
	      errors: undefined
	    };
	    this.loadFields();
	    this.handleValueChange = this.handleValueChange.bind(this);
	    this.handleSave = this.handleSave.bind(this);
	    this.onItemLoad = this.onItemLoad.bind(this);
	  }

	  _createClass(DynamicSegmentForm, [{
	    key: 'onItemLoad',
	    value: function onItemLoad(loadedData) {
	      var item = _underscore2['default'].mapObject(loadedData, function (val) {
	        return _underscore2['default'].isNull(val) ? '' : val; // react doesn't like nulls
	      });
	      this.setState({ item: item }, this.loadFields);
	    }
	  }, {
	    key: 'loadFields',
	    value: function loadFields() {
	      var _this = this;

	      this.getChildFields().then(function (fields) {
	        return _this.setState({
	          childFields: fields,
	          loading: false
	        });
	      });
	    }
	  }, {
	    key: 'getFields',
	    value: function getFields() {
	      return [{
	        name: 'name',
	        label: _mailpoet2['default'].I18n.t('name'),
	        type: 'text'
	      }, {
	        name: 'description',
	        label: _mailpoet2['default'].I18n.t('description'),
	        type: 'textarea',
	        tip: _mailpoet2['default'].I18n.t('descriptionTip')
	      }, {
	        name: 'filters',
	        description: 'main',
	        label: _mailpoet2['default'].I18n.t('formSegmentTitle'),
	        fields: [{
	          name: 'segmentType',
	          type: 'select',
	          values: this.getAvailableFilters()
	        }].concat(_toConsumableArray(this.state.childFields))
	      }];
	    }
	  }, {
	    key: 'getAvailableFilters',
	    value: function getAvailableFilters() {
	      var filters = {
	        email: _mailpoet2['default'].I18n.t('email'),
	        userRole: _mailpoet2['default'].I18n.t('wpUserRole')
	      };
	      if (window.is_woocommerce_active) {
	        filters.woocommerce = _mailpoet2['default'].I18n.t('woocommerce');
	      }
	      return filters;
	    }
	  }, {
	    key: 'getChildFields',
	    value: function getChildFields() {
	      switch (this.state.item.segmentType) {
	        case 'userRole':
	          return (0, _filtersWordpress_role2['default'])();

	        case 'email':
	          return (0, _filtersEmail2['default'])(this.state.item);

	        case 'woocommerce':
	          return (0, _filtersWoocommerce2['default'])(this.state.item);

	        default:
	          return [];
	      }
	    }
	  }, {
	    key: 'handleValueChange',
	    value: function handleValueChange(e) {
	      var item = this.state.item;
	      var field = e.target.name;

	      item[field] = e.target.value;

	      this.setState({
	        item: item
	      });
	      this.loadFields();
	      return true;
	    }
	  }, {
	    key: 'handleSave',
	    value: function handleSave(e) {
	      var _this2 = this;

	      e.preventDefault();
	      this.setState({ errors: undefined });
	      _mailpoet2['default'].Ajax.post({
	        api_version: window.mailpoet_api_version,
	        endpoint: 'dynamic_segments',
	        action: 'save',
	        data: this.state.item
	      }).done(function () {
	        _this2.context.router.push('/');

	        if (_this2.props.params.id !== undefined) {
	          messages.onUpdate();
	        } else {
	          messages.onCreate(_this2.state.item);
	        }
	      }).fail(function (response) {
	        if (response.errors.length > 0) {
	          _this2.setState({ errors: response.errors });
	        }
	      });
	    }
	  }, {
	    key: 'render',
	    value: function render() {
	      var fields = this.getFields();
	      return _react2['default'].createElement(
	        'div',
	        null,
	        _react2['default'].createElement(
	          'h1',
	          { className: 'title' },
	          _mailpoet2['default'].I18n.t('formPageTitle'),
	          ' ',
	          _react2['default'].createElement(
	            _reactRouter.Link,
	            { className: 'page-title-action', to: '/' },
	            _mailpoet2['default'].I18n.t('backToList')
	          )
	        ),
	        _react2['default'].createElement(_form2['default'], {
	          endpoint: 'dynamic_segments',
	          fields: fields,
	          params: this.props.params,
	          messages: messages,
	          onChange: this.handleValueChange,
	          onSubmit: this.handleSave,
	          onItemLoad: this.onItemLoad,
	          item: this.state.item,
	          errors: this.state.errors
	        })
	      );
	    }
	  }]);

	  return DynamicSegmentForm;
	})(_react2['default'].Component);

	DynamicSegmentForm.contextTypes = {
	  router: _react2['default'].PropTypes.object.isRequired
	};

	module.exports = DynamicSegmentForm;

/***/ },
/* 24 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.Form;

/***/ },
/* 25 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

	var _underscore = __webpack_require__(2);

	var _underscore2 = _interopRequireDefault(_underscore);

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	module.exports = function () {
	  return Promise.resolve([{
	    name: 'wordpressRole',
	    type: 'select',
	    placeholder: _mailpoet2['default'].I18n.t('selectUserRolePlaceholder'),
	    values: window.wordpress_editable_roles_list.reduce(function (currentValue, accumulator) {
	      return _underscore2['default'].extend({}, currentValue, _defineProperty({}, accumulator.role_id, accumulator.role_name));
	    }, {})
	  }]);
	};

/***/ },
/* 26 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var loadedLinks = {};

	function loadLinks(formItems) {
	  if (formItems.action !== 'clicked' && formItems.action !== 'notClicked') return Promise.resolve();
	  if (!formItems.newsletter_id) return Promise.resolve();
	  if (loadedLinks[formItems.newsletter_id] !== undefined) {
	    return Promise.resolve(loadedLinks[formItems.newsletter_id]);
	  }

	  return _mailpoet2['default'].Ajax.post({
	    api_version: window.mailpoet_api_version,
	    endpoint: 'newsletter_links',
	    action: 'get',
	    data: {
	      newsletterId: formItems.newsletter_id
	    }
	  }).then(function (response) {
	    var data = response.data;
	    loadedLinks[formItems.newsletter_id] = data;
	    return data;
	  }).fail(function (response) {
	    _mailpoet2['default'].Notice.error(response.errors.map(function (error) {
	      return error.message;
	    }), { scroll: true });
	  });
	}

	module.exports = function (formItems) {
	  return loadLinks(formItems).then(function (links) {
	    var basicFields = [{
	      name: 'action',
	      type: 'select',
	      values: {
	        '': _mailpoet2['default'].I18n.t('selectActionPlaceholder'),
	        opened: _mailpoet2['default'].I18n.t('emailActionOpened'),
	        notOpened: _mailpoet2['default'].I18n.t('emailActionNotOpened'),
	        clicked: _mailpoet2['default'].I18n.t('emailActionClicked'),
	        notClicked: _mailpoet2['default'].I18n.t('emailActionNotClicked')
	      }
	    }, {
	      name: 'newsletter_id',
	      type: 'selection',
	      resetSelect2OnUpdate: true,
	      endpoint: 'newsletters_list',
	      placeholder: _mailpoet2['default'].I18n.t('selectNewsletterPlaceholder'),
	      forceSelect2: true,
	      getLabel: function getLabel(newsletter) {
	        var sentAt = newsletter.sent_at ? _mailpoet2['default'].Date.format(newsletter.sent_at) : _mailpoet2['default'].I18n.t('notSentYet');
	        return newsletter.subject + ' (' + sentAt + ')';
	      }
	    }];
	    if (links) {
	      return [].concat(basicFields, [{
	        name: 'link_id',
	        type: 'selection',
	        placeholder: _mailpoet2['default'].I18n.t('selectLinkPlaceholder'),
	        forceSelect2: true,
	        getLabel: function getLabel(link) {
	          return link.url;
	        },
	        values: links
	      }]);
	    }
	    return basicFields;
	  });
	};

/***/ },
/* 27 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

	var _mailpoet = __webpack_require__(5);

	var _mailpoet2 = _interopRequireDefault(_mailpoet);

	var _underscore = __webpack_require__(2);

	var _underscore2 = _interopRequireDefault(_underscore);

	var actionsField = {
	  name: 'action',
	  type: 'select',
	  values: {
	    '': _mailpoet2['default'].I18n.t('selectActionPlaceholder'),
	    purchasedCategory: _mailpoet2['default'].I18n.t('wooPurchasedCategory'),
	    purchasedProduct: _mailpoet2['default'].I18n.t('wooPurchasedProduct')
	  }
	};

	var categoriesField = {
	  name: 'category_id',
	  type: 'selection',
	  endpoint: 'product_categories',
	  resetSelect2OnUpdate: true,
	  placeholder: _mailpoet2['default'].I18n.t('selectWooPurchasedCategory'),
	  forceSelect2: true,
	  getLabel: _underscore2['default'].property('cat_name'),
	  getValue: _underscore2['default'].property('term_id')
	};

	var productsField = {
	  name: 'product_id',
	  type: 'selection',
	  endpoint: 'products',
	  resetSelect2OnUpdate: true,
	  placeholder: _mailpoet2['default'].I18n.t('selectWooPurchasedProduct'),
	  forceSelect2: true,
	  getLabel: _underscore2['default'].property('title'),
	  getValue: _underscore2['default'].property('ID')
	};

	module.exports = function (formItems) {
	  var formFields = [actionsField];
	  if (formItems.action === 'purchasedCategory') {
	    formFields.push(categoriesField);
	  }
	  if (formItems.action === 'purchasedProduct') {
	    formFields.push(productsField);
	  }
	  return Promise.resolve(formFields);
	};

/***/ },
/* 28 */
/***/ function(module, exports) {

	module.exports = MailPoetLib.History;

/***/ }
/******/ ]);