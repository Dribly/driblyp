<?php

namespace App\Library\Services;
/*
 * Sample response
 * {
  "latitude": 51.44,
  "longitude": -0.3,
  "timezone": "Europe/London",
  "currently": {
    "time": 1554380885,
    "summary": "Drizzle",
    "icon": "rain",
    "nearestStormDistance": 0,
    "precipIntensity": 0.0052,
    "precipIntensityError": 0.0032,
    "precipProbability": 0.7,
    "precipType": "rain",
    "temperature": 49.24,
    "apparentTemperature": 43.58,
    "dewPoint": 37.76,
    "humidity": 0.64,
    "pressure": 994.25,
    "windSpeed": 15.4,
    "windGust": 29.99,
    "windBearing": 173,
    "cloudCover": 0.56,
    "uvIndex": 2,
    "visibility": 8.77,
    "ozone": 458.41
  },
  "minutely": {
    "summary": "Drizzle stopping in 25 min.",
    "icon": "rain",
    "data": [
      {
        "time": 1554380880,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.003,
        "precipProbability": 0.68,
        "precipType": "rain"
      },
      {
        "time": 1554380940,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.89,
        "precipType": "rain"
      },
      {
        "time": 1554381000,
        "precipIntensity": 0.009,
        "precipIntensityError": 0.005,
        "precipProbability": 0.96,
        "precipType": "rain"
      },
      {
        "time": 1554381060,
        "precipIntensity": 0.009,
        "precipIntensityError": 0.005,
        "precipProbability": 0.97,
        "precipType": "rain"
      },
      {
        "time": 1554381120,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.004,
        "precipProbability": 0.95,
        "precipType": "rain"
      },
      {
        "time": 1554381180,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.004,
        "precipProbability": 0.91,
        "precipType": "rain"
      },
      {
        "time": 1554381240,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.003,
        "precipProbability": 0.88,
        "precipType": "rain"
      },
      {
        "time": 1554381300,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.003,
        "precipProbability": 0.87,
        "precipType": "rain"
      },
      {
        "time": 1554381360,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.003,
        "precipProbability": 0.85,
        "precipType": "rain"
      },
      {
        "time": 1554381420,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.85,
        "precipType": "rain"
      },
      {
        "time": 1554381480,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.86,
        "precipType": "rain"
      },
      {
        "time": 1554381540,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.88,
        "precipType": "rain"
      },
      {
        "time": 1554381600,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.006,
        "precipProbability": 0.88,
        "precipType": "rain"
      },
      {
        "time": 1554381660,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.87,
        "precipType": "rain"
      },
      {
        "time": 1554381720,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.005,
        "precipProbability": 0.86,
        "precipType": "rain"
      },
      {
        "time": 1554381780,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.005,
        "precipProbability": 0.83,
        "precipType": "rain"
      },
      {
        "time": 1554381840,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.8,
        "precipType": "rain"
      },
      {
        "time": 1554381900,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.73,
        "precipType": "rain"
      },
      {
        "time": 1554381960,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.005,
        "precipProbability": 0.68,
        "precipType": "rain"
      },
      {
        "time": 1554382020,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.59,
        "precipType": "rain"
      },
      {
        "time": 1554382080,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.57,
        "precipType": "rain"
      },
      {
        "time": 1554382140,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.003,
        "precipProbability": 0.54,
        "precipType": "rain"
      },
      {
        "time": 1554382200,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.54,
        "precipType": "rain"
      },
      {
        "time": 1554382260,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.55,
        "precipType": "rain"
      },
      {
        "time": 1554382320,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.55,
        "precipType": "rain"
      },
      {
        "time": 1554382380,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.004,
        "precipProbability": 0.56,
        "precipType": "rain"
      },
      {
        "time": 1554382440,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.51,
        "precipType": "rain"
      },
      {
        "time": 1554382500,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.47,
        "precipType": "rain"
      },
      {
        "time": 1554382560,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.42,
        "precipType": "rain"
      },
      {
        "time": 1554382620,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.37,
        "precipType": "rain"
      },
      {
        "time": 1554382680,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.3,
        "precipType": "rain"
      },
      {
        "time": 1554382740,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.24,
        "precipType": "rain"
      },
      {
        "time": 1554382800,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.21,
        "precipType": "rain"
      },
      {
        "time": 1554382860,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.17,
        "precipType": "rain"
      },
      {
        "time": 1554382920,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.14,
        "precipType": "rain"
      },
      {
        "time": 1554382980,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.12,
        "precipType": "rain"
      },
      {
        "time": 1554383040,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.006,
        "precipProbability": 0.1,
        "precipType": "rain"
      },
      {
        "time": 1554383100,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.006,
        "precipProbability": 0.08,
        "precipType": "rain"
      },
      {
        "time": 1554383160,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.005,
        "precipProbability": 0.08,
        "precipType": "rain"
      },
      {
        "time": 1554383220,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.005,
        "precipProbability": 0.06,
        "precipType": "rain"
      },
      {
        "time": 1554383280,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.004,
        "precipProbability": 0.05,
        "precipType": "rain"
      },
      {
        "time": 1554383340,
        "precipIntensity": 0.006,
        "precipIntensityError": 0.005,
        "precipProbability": 0.04,
        "precipType": "rain"
      },
      {
        "time": 1554383400,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.004,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554383460,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.004,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554383520,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.004,
        "precipProbability": 0.02,
        "precipType": "rain"
      },
      {
        "time": 1554383580,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.004,
        "precipProbability": 0.02,
        "precipType": "rain"
      },
      {
        "time": 1554383640,
        "precipIntensity": 0.005,
        "precipIntensityError": 0.003,
        "precipProbability": 0.02,
        "precipType": "rain"
      },
      {
        "time": 1554383700,
        "precipIntensity": 0,
        "precipProbability": 0
      },
      {
        "time": 1554383760,
        "precipIntensity": 0,
        "precipProbability": 0
      },
      {
        "time": 1554383820,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.02,
        "precipType": "rain"
      },
      {
        "time": 1554383880,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.02,
        "precipType": "rain"
      },
      {
        "time": 1554383940,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384000,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384060,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384120,
        "precipIntensity": 0,
        "precipProbability": 0
      },
      {
        "time": 1554384180,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.04,
        "precipType": "rain"
      },
      {
        "time": 1554384240,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384300,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384360,
        "precipIntensity": 0.008,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384420,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      },
      {
        "time": 1554384480,
        "precipIntensity": 0.007,
        "precipIntensityError": 0.005,
        "precipProbability": 0.03,
        "precipType": "rain"
      }
    ]
  },
  "hourly": {
    "summary": "Mostly cloudy until tomorrow afternoon.",
    "icon": "partly-cloudy-night",
    "data": [
      {
        "time": 1554379200,
        "summary": "Partly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0.0008,
        "precipProbability": 0.89,
        "precipType": "rain",
        "temperature": 48.97,
        "apparentTemperature": 43.29,
        "dewPoint": 37.62,
        "humidity": 0.65,
        "pressure": 994.15,
        "windSpeed": 15.15,
        "windGust": 30.18,
        "windBearing": 172,
        "cloudCover": 0.57,
        "uvIndex": 2,
        "visibility": 8.88,
        "ozone": 458.67
      },
      {
        "time": 1554382800,
        "summary": "Drizzle",
        "icon": "rain",
        "precipIntensity": 0.0064,
        "precipProbability": 0.97,
        "precipType": "rain",
        "temperature": 49.55,
        "apparentTemperature": 43.91,
        "dewPoint": 37.91,
        "humidity": 0.64,
        "pressure": 994.37,
        "windSpeed": 15.69,
        "windGust": 29.78,
        "windBearing": 175,
        "cloudCover": 0.56,
        "uvIndex": 2,
        "visibility": 8.65,
        "ozone": 458.12
      },
      {
        "time": 1554386400,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0.0011,
        "precipProbability": 0.12,
        "precipType": "rain",
        "temperature": 50.6,
        "apparentTemperature": 50.6,
        "dewPoint": 36.58,
        "humidity": 0.58,
        "pressure": 994.59,
        "windSpeed": 17.23,
        "windGust": 28.31,
        "windBearing": 175,
        "cloudCover": 0.68,
        "uvIndex": 2,
        "visibility": 8.48,
        "ozone": 457.22
      },
      {
        "time": 1554390000,
        "summary": "Breezy and Mostly Cloudy",
        "icon": "wind",
        "precipIntensity": 0.0016,
        "precipProbability": 0.13,
        "precipType": "rain",
        "temperature": 51.19,
        "apparentTemperature": 51.19,
        "dewPoint": 35.89,
        "humidity": 0.56,
        "pressure": 994.88,
        "windSpeed": 17.74,
        "windGust": 26.88,
        "windBearing": 174,
        "cloudCover": 0.77,
        "uvIndex": 1,
        "visibility": 7.78,
        "ozone": 454.61
      },
      {
        "time": 1554393600,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0.0041,
        "precipProbability": 0.19,
        "precipType": "rain",
        "temperature": 51.28,
        "apparentTemperature": 51.28,
        "dewPoint": 36.35,
        "humidity": 0.57,
        "pressure": 995.29,
        "windSpeed": 16.54,
        "windGust": 25.62,
        "windBearing": 172,
        "cloudCover": 0.77,
        "uvIndex": 1,
        "visibility": 5.99,
        "ozone": 449.1
      },
      {
        "time": 1554397200,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0.0119,
        "precipProbability": 0.29,
        "precipType": "rain",
        "temperature": 50.52,
        "apparentTemperature": 50.52,
        "dewPoint": 36.77,
        "humidity": 0.59,
        "pressure": 995.78,
        "windSpeed": 15,
        "windGust": 24.17,
        "windBearing": 170,
        "cloudCover": 0.8,
        "uvIndex": 0,
        "visibility": 3.88,
        "ozone": 441.95
      },
      {
        "time": 1554400800,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0.0176,
        "precipProbability": 0.39,
        "precipType": "rain",
        "temperature": 47.9,
        "apparentTemperature": 42.12,
        "dewPoint": 38.4,
        "humidity": 0.69,
        "pressure": 996.33,
        "windSpeed": 14.34,
        "windGust": 23.14,
        "windBearing": 166,
        "cloudCover": 0.83,
        "uvIndex": 0,
        "visibility": 2.64,
        "ozone": 435.27
      },
      {
        "time": 1554404400,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0.012,
        "precipProbability": 0.36,
        "precipType": "rain",
        "temperature": 47.43,
        "apparentTemperature": 41.78,
        "dewPoint": 38.62,
        "humidity": 0.71,
        "pressure": 997,
        "windSpeed": 13.43,
        "windGust": 22.94,
        "windBearing": 162,
        "cloudCover": 0.89,
        "uvIndex": 0,
        "visibility": 2.68,
        "ozone": 430.18
      },
      {
        "time": 1554408000,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0045,
        "precipProbability": 0.26,
        "precipType": "rain",
        "temperature": 46.95,
        "apparentTemperature": 41.39,
        "dewPoint": 38.76,
        "humidity": 0.73,
        "pressure": 997.76,
        "windSpeed": 12.65,
        "windGust": 23.18,
        "windBearing": 158,
        "cloudCover": 0.96,
        "uvIndex": 0,
        "visibility": 3.57,
        "ozone": 425.65
      },
      {
        "time": 1554411600,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0019,
        "precipProbability": 0.17,
        "precipType": "rain",
        "temperature": 46.53,
        "apparentTemperature": 41.07,
        "dewPoint": 38.82,
        "humidity": 0.74,
        "pressure": 998.38,
        "windSpeed": 11.96,
        "windGust": 23.42,
        "windBearing": 155,
        "cloudCover": 1,
        "uvIndex": 0,
        "visibility": 5.25,
        "ozone": 420.57
      },
      {
        "time": 1554415200,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0012,
        "precipProbability": 0.1,
        "precipType": "rain",
        "temperature": 46.05,
        "apparentTemperature": 40.69,
        "dewPoint": 38.72,
        "humidity": 0.75,
        "pressure": 998.77,
        "windSpeed": 11.26,
        "windGust": 23.47,
        "windBearing": 152,
        "cloudCover": 1,
        "uvIndex": 0,
        "visibility": 8.33,
        "ozone": 414.25
      },
      {
        "time": 1554418800,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0007,
        "precipProbability": 0.06,
        "precipType": "rain",
        "temperature": 45.6,
        "apparentTemperature": 40.36,
        "dewPoint": 38.53,
        "humidity": 0.76,
        "pressure": 999.04,
        "windSpeed": 10.62,
        "windGust": 23.53,
        "windBearing": 150,
        "cloudCover": 1,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 407.42
      },
      {
        "time": 1554422400,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0.0006,
        "precipProbability": 0.04,
        "precipType": "rain",
        "temperature": 45.26,
        "apparentTemperature": 40.05,
        "dewPoint": 38.24,
        "humidity": 0.76,
        "pressure": 999.25,
        "windSpeed": 10.3,
        "windGust": 23.77,
        "windBearing": 149,
        "cloudCover": 0.91,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 401.12
      },
      {
        "time": 1554426000,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0.0003,
        "precipProbability": 0.03,
        "precipType": "rain",
        "temperature": 44.76,
        "apparentTemperature": 39.39,
        "dewPoint": 37.77,
        "humidity": 0.76,
        "pressure": 999.39,
        "windSpeed": 10.43,
        "windGust": 24.4,
        "windBearing": 145,
        "cloudCover": 0.64,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 395.54
      },
      {
        "time": 1554429600,
        "summary": "Partly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 44.43,
        "apparentTemperature": 38.81,
        "dewPoint": 37.22,
        "humidity": 0.76,
        "pressure": 999.49,
        "windSpeed": 10.85,
        "windGust": 25.22,
        "windBearing": 141,
        "cloudCover": 0.27,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 390.58
      },
      {
        "time": 1554433200,
        "summary": "Clear",
        "icon": "clear-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 44.23,
        "apparentTemperature": 38.42,
        "dewPoint": 36.8,
        "humidity": 0.75,
        "pressure": 999.69,
        "windSpeed": 11.28,
        "windGust": 25.81,
        "windBearing": 138,
        "cloudCover": 0.02,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 386.34
      },
      {
        "time": 1554436800,
        "summary": "Clear",
        "icon": "clear-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 44.91,
        "apparentTemperature": 39.27,
        "dewPoint": 36.59,
        "humidity": 0.72,
        "pressure": 1000.09,
        "windSpeed": 11.28,
        "windGust": 26.12,
        "windBearing": 137,
        "cloudCover": 0.01,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 383.3
      },
      {
        "time": 1554440400,
        "summary": "Clear",
        "icon": "clear-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 45.21,
        "apparentTemperature": 39.5,
        "dewPoint": 36.59,
        "humidity": 0.72,
        "pressure": 1000.59,
        "windSpeed": 11.68,
        "windGust": 26.22,
        "windBearing": 136,
        "cloudCover": 0.09,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 381.09
      },
      {
        "time": 1554444000,
        "summary": "Clear",
        "icon": "clear-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 45.97,
        "apparentTemperature": 40.33,
        "dewPoint": 36.53,
        "humidity": 0.69,
        "pressure": 1001.12,
        "windSpeed": 12.09,
        "windGust": 25.86,
        "windBearing": 137,
        "cloudCover": 0.24,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 378.97
      },
      {
        "time": 1554447600,
        "summary": "Partly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 47.16,
        "apparentTemperature": 41.69,
        "dewPoint": 36.34,
        "humidity": 0.66,
        "pressure": 1001.69,
        "windSpeed": 12.54,
        "windGust": 24.68,
        "windBearing": 138,
        "cloudCover": 0.47,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 376.91
      },
      {
        "time": 1554451200,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 48.96,
        "apparentTemperature": 43.84,
        "dewPoint": 36.39,
        "humidity": 0.62,
        "pressure": 1002.27,
        "windSpeed": 12.97,
        "windGust": 23.07,
        "windBearing": 140,
        "cloudCover": 0.75,
        "uvIndex": 1,
        "visibility": 10,
        "ozone": 375.09
      },
      {
        "time": 1554454800,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 50.93,
        "apparentTemperature": 50.93,
        "dewPoint": 36.51,
        "humidity": 0.58,
        "pressure": 1002.76,
        "windSpeed": 13.3,
        "windGust": 21.9,
        "windBearing": 141,
        "cloudCover": 0.95,
        "uvIndex": 1,
        "visibility": 10,
        "ozone": 372.76
      },
      {
        "time": 1554458400,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 52.72,
        "apparentTemperature": 52.72,
        "dewPoint": 36.12,
        "humidity": 0.53,
        "pressure": 1003.08,
        "windSpeed": 13.59,
        "windGust": 21.73,
        "windBearing": 142,
        "cloudCover": 0.99,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 369.42
      },
      {
        "time": 1554462000,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 54.65,
        "apparentTemperature": 54.65,
        "dewPoint": 35.37,
        "humidity": 0.48,
        "pressure": 1003.32,
        "windSpeed": 13.82,
        "windGust": 21.99,
        "windBearing": 144,
        "cloudCover": 0.97,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 365.67
      },
      {
        "time": 1554465600,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 55.9,
        "apparentTemperature": 55.9,
        "dewPoint": 34.67,
        "humidity": 0.45,
        "pressure": 1003.45,
        "windSpeed": 13.79,
        "windGust": 21.8,
        "windBearing": 142,
        "cloudCover": 0.95,
        "uvIndex": 3,
        "visibility": 10,
        "ozone": 362.93
      },
      {
        "time": 1554469200,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 56.57,
        "apparentTemperature": 56.57,
        "dewPoint": 34.12,
        "humidity": 0.43,
        "pressure": 1003.44,
        "windSpeed": 13.29,
        "windGust": 20.48,
        "windBearing": 138,
        "cloudCover": 0.93,
        "uvIndex": 3,
        "visibility": 10,
        "ozone": 361.9
      },
      {
        "time": 1554472800,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 56.36,
        "apparentTemperature": 56.36,
        "dewPoint": 33.63,
        "humidity": 0.42,
        "pressure": 1003.34,
        "windSpeed": 12.5,
        "windGust": 18.71,
        "windBearing": 132,
        "cloudCover": 0.91,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 361.9
      },
      {
        "time": 1554476400,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 56.03,
        "apparentTemperature": 56.03,
        "dewPoint": 33.28,
        "humidity": 0.42,
        "pressure": 1003.27,
        "windSpeed": 11.79,
        "windGust": 17.62,
        "windBearing": 124,
        "cloudCover": 0.89,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 362.22
      },
      {
        "time": 1554480000,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 55.62,
        "apparentTemperature": 55.62,
        "dewPoint": 33.18,
        "humidity": 0.42,
        "pressure": 1003.24,
        "windSpeed": 11.2,
        "windGust": 17.71,
        "windBearing": 114,
        "cloudCover": 0.9,
        "uvIndex": 1,
        "visibility": 10,
        "ozone": 362.75
      },
      {
        "time": 1554483600,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 54.83,
        "apparentTemperature": 54.83,
        "dewPoint": 33.3,
        "humidity": 0.44,
        "pressure": 1003.25,
        "windSpeed": 10.74,
        "windGust": 18.5,
        "windBearing": 102,
        "cloudCover": 0.93,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 363.47
      },
      {
        "time": 1554487200,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 53.7,
        "apparentTemperature": 53.7,
        "dewPoint": 33.69,
        "humidity": 0.47,
        "pressure": 1003.36,
        "windSpeed": 10.56,
        "windGust": 19.65,
        "windBearing": 93,
        "cloudCover": 0.95,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 364.27
      },
      {
        "time": 1554490800,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 52.82,
        "apparentTemperature": 52.82,
        "dewPoint": 34.54,
        "humidity": 0.5,
        "pressure": 1003.7,
        "windSpeed": 10.84,
        "windGust": 21.35,
        "windBearing": 88,
        "cloudCover": 0.96,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 364.88
      },
      {
        "time": 1554494400,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 51.71,
        "apparentTemperature": 51.71,
        "dewPoint": 35.65,
        "humidity": 0.54,
        "pressure": 1004.14,
        "windSpeed": 11.22,
        "windGust": 23.4,
        "windBearing": 85,
        "cloudCover": 0.98,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 365.44
      },
      {
        "time": 1554498000,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 49.04,
        "apparentTemperature": 44.76,
        "dewPoint": 34.65,
        "humidity": 0.57,
        "pressure": 1004.45,
        "windSpeed": 10.26,
        "windGust": 24.95,
        "windBearing": 84,
        "cloudCover": 0.99,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 365.99
      },
      {
        "time": 1554501600,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 49.49,
        "apparentTemperature": 44.95,
        "dewPoint": 36.88,
        "humidity": 0.62,
        "pressure": 1004.49,
        "windSpeed": 11.4,
        "windGust": 25.65,
        "windBearing": 82,
        "cloudCover": 1,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 366.52
      },
      {
        "time": 1554505200,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 48.84,
        "apparentTemperature": 44.2,
        "dewPoint": 36.93,
        "humidity": 0.63,
        "pressure": 1004.37,
        "windSpeed": 11.22,
        "windGust": 25.85,
        "windBearing": 81,
        "cloudCover": 0.99,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 366.96
      },
      {
        "time": 1554508800,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 48.18,
        "apparentTemperature": 43.46,
        "dewPoint": 37.22,
        "humidity": 0.66,
        "pressure": 1004.24,
        "windSpeed": 10.96,
        "windGust": 25.65,
        "windBearing": 79,
        "cloudCover": 0.98,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 367.57
      },
      {
        "time": 1554512400,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 47.65,
        "apparentTemperature": 42.91,
        "dewPoint": 37.86,
        "humidity": 0.69,
        "pressure": 1004.08,
        "windSpeed": 10.63,
        "windGust": 24.93,
        "windBearing": 76,
        "cloudCover": 0.94,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 368.47
      },
      {
        "time": 1554516000,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 47.16,
        "apparentTemperature": 42.41,
        "dewPoint": 38.59,
        "humidity": 0.72,
        "pressure": 1003.9,
        "windSpeed": 10.28,
        "windGust": 23.83,
        "windBearing": 73,
        "cloudCover": 0.88,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 369.51
      },
      {
        "time": 1554519600,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 46.6,
        "apparentTemperature": 41.8,
        "dewPoint": 39.22,
        "humidity": 0.75,
        "pressure": 1003.79,
        "windSpeed": 10.06,
        "windGust": 23.03,
        "windBearing": 69,
        "cloudCover": 0.85,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 370.34
      },
      {
        "time": 1554523200,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 45.86,
        "apparentTemperature": 40.86,
        "dewPoint": 39.57,
        "humidity": 0.79,
        "pressure": 1003.83,
        "windSpeed": 10.12,
        "windGust": 23.04,
        "windBearing": 67,
        "cloudCover": 0.84,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 370.58
      },
      {
        "time": 1554526800,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-night",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 45.2,
        "apparentTemperature": 39.96,
        "dewPoint": 39.72,
        "humidity": 0.81,
        "pressure": 1003.94,
        "windSpeed": 10.34,
        "windGust": 23.37,
        "windBearing": 66,
        "cloudCover": 0.85,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 370.61
      },
      {
        "time": 1554530400,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 44.91,
        "apparentTemperature": 39.53,
        "dewPoint": 39.83,
        "humidity": 0.82,
        "pressure": 1004.02,
        "windSpeed": 10.53,
        "windGust": 23.25,
        "windBearing": 65,
        "cloudCover": 0.87,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 370.89
      },
      {
        "time": 1554534000,
        "summary": "Mostly Cloudy",
        "icon": "partly-cloudy-day",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 45.75,
        "apparentTemperature": 40.51,
        "dewPoint": 39.97,
        "humidity": 0.8,
        "pressure": 1004.05,
        "windSpeed": 10.74,
        "windGust": 22.19,
        "windBearing": 63,
        "cloudCover": 0.91,
        "uvIndex": 0,
        "visibility": 10,
        "ozone": 371.97
      },
      {
        "time": 1554537600,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 47.77,
        "apparentTemperature": 42.92,
        "dewPoint": 40.22,
        "humidity": 0.75,
        "pressure": 1004.05,
        "windSpeed": 11.04,
        "windGust": 20.72,
        "windBearing": 62,
        "cloudCover": 0.96,
        "uvIndex": 1,
        "visibility": 10,
        "ozone": 373.36
      },
      {
        "time": 1554541200,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 49.58,
        "apparentTemperature": 45.08,
        "dewPoint": 40.57,
        "humidity": 0.71,
        "pressure": 1004.03,
        "windSpeed": 11.38,
        "windGust": 19.61,
        "windBearing": 61,
        "cloudCover": 1,
        "uvIndex": 1,
        "visibility": 10,
        "ozone": 374.06
      },
      {
        "time": 1554544800,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0002,
        "precipProbability": 0.01,
        "precipType": "rain",
        "temperature": 50.88,
        "apparentTemperature": 50.88,
        "dewPoint": 40.97,
        "humidity": 0.69,
        "pressure": 1003.94,
        "windSpeed": 11.61,
        "windGust": 19.3,
        "windBearing": 61,
        "cloudCover": 1,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 373.57
      },
      {
        "time": 1554548400,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0.0002,
        "precipProbability": 0.01,
        "precipType": "rain",
        "temperature": 52.13,
        "apparentTemperature": 52.13,
        "dewPoint": 41.38,
        "humidity": 0.67,
        "pressure": 1003.81,
        "windSpeed": 11.77,
        "windGust": 19.35,
        "windBearing": 62,
        "cloudCover": 1,
        "uvIndex": 2,
        "visibility": 10,
        "ozone": 372.51
      },
      {
        "time": 1554552000,
        "summary": "Overcast",
        "icon": "cloudy",
        "precipIntensity": 0,
        "precipProbability": 0,
        "temperature": 53.26,
        "apparentTemperature": 53.26,
        "dewPoint": 41.59,
        "humidity": 0.64,
        "pressure": 1003.64,
        "windSpeed": 11.8,
        "windGust": 19.27,
        "windBearing": 63,
        "cloudCover": 1,
        "uvIndex": 3,
        "visibility": 10,
        "ozone": 372.22
      }
    ]
  },
  "daily": {
    "summary": "Light rain today, with high temperatures peaking at 62°F on Sunday.",
    "icon": "rain",
    "data": [
      {
        "time": 1554332400,
        "summary": "Mostly cloudy throughout the day.",
        "icon": "partly-cloudy-day",
        "sunriseTime": 1554355876,
        "sunsetTime": 1554403163,
        "moonPhase": 0.97,
        "precipIntensity": 0.0035,
        "precipIntensityMax": 0.0176,
        "precipIntensityMaxTime": 1554400800,
        "precipProbability": 0.99,
        "precipType": "rain",
        "temperatureHigh": 51.28,
        "temperatureHighTime": 1554393600,
        "temperatureLow": 44.23,
        "temperatureLowTime": 1554433200,
        "apparentTemperatureHigh": 51.28,
        "apparentTemperatureHighTime": 1554393600,
        "apparentTemperatureLow": 38.42,
        "apparentTemperatureLowTime": 1554433200,
        "dewPoint": 35.81,
        "humidity": 0.76,
        "pressure": 995.25,
        "windSpeed": 10.68,
        "windGust": 33.74,
        "windGustTime": 1554372000,
        "windBearing": 156,
        "cloudCover": 0.72,
        "uvIndex": 2,
        "uvIndexTime": 1554372000,
        "visibility": 6.05,
        "ozone": 454.02,
        "temperatureMin": 32.56,
        "temperatureMinTime": 1554332400,
        "temperatureMax": 51.28,
        "temperatureMaxTime": 1554393600,
        "apparentTemperatureMin": 28.75,
        "apparentTemperatureMinTime": 1554332400,
        "apparentTemperatureMax": 51.28,
        "apparentTemperatureMaxTime": 1554393600
      },
      {
        "time": 1554418800,
        "summary": "Mostly cloudy throughout the day.",
        "icon": "partly-cloudy-day",
        "sunriseTime": 1554442141,
        "sunsetTime": 1554489662,
        "moonPhase": 0.01,
        "precipIntensity": 0.0001,
        "precipIntensityMax": 0.0007,
        "precipIntensityMaxTime": 1554418800,
        "precipProbability": 0.14,
        "precipType": "rain",
        "temperatureHigh": 56.57,
        "temperatureHighTime": 1554469200,
        "temperatureLow": 44.91,
        "temperatureLowTime": 1554530400,
        "apparentTemperatureHigh": 56.57,
        "apparentTemperatureHighTime": 1554469200,
        "apparentTemperatureLow": 39.53,
        "apparentTemperatureLowTime": 1554530400,
        "dewPoint": 35.69,
        "humidity": 0.59,
        "pressure": 1002.16,
        "windSpeed": 10.92,
        "windGust": 26.22,
        "windGustTime": 1554440400,
        "windBearing": 127,
        "cloudCover": 0.74,
        "uvIndex": 3,
        "uvIndexTime": 1554465600,
        "visibility": 10,
        "ozone": 374.44,
        "temperatureMin": 44.23,
        "temperatureMinTime": 1554433200,
        "temperatureMax": 56.57,
        "temperatureMaxTime": 1554469200,
        "apparentTemperatureMin": 38.42,
        "apparentTemperatureMinTime": 1554433200,
        "apparentTemperatureMax": 56.57,
        "apparentTemperatureMaxTime": 1554469200
      },
      {
        "time": 1554505200,
        "summary": "Overcast throughout the day.",
        "icon": "cloudy",
        "sunriseTime": 1554528406,
        "sunsetTime": 1554576162,
        "moonPhase": 0.04,
        "precipIntensity": 0.0003,
        "precipIntensityMax": 0.0009,
        "precipIntensityMaxTime": 1554570000,
        "precipProbability": 0.21,
        "precipType": "rain",
        "temperatureHigh": 55.65,
        "temperatureHighTime": 1554562800,
        "temperatureLow": 44.36,
        "temperatureLowTime": 1554613200,
        "apparentTemperatureHigh": 55.65,
        "apparentTemperatureHighTime": 1554562800,
        "apparentTemperatureLow": 41.39,
        "apparentTemperatureLowTime": 1554613200,
        "dewPoint": 40.4,
        "humidity": 0.69,
        "pressure": 1003.72,
        "windSpeed": 10.56,
        "windGust": 25.85,
        "windGustTime": 1554505200,
        "windBearing": 67,
        "cloudCover": 0.96,
        "uvIndex": 3,
        "uvIndexTime": 1554552000,
        "visibility": 10,
        "ozone": 374.05,
        "temperatureMin": 44.91,
        "temperatureMinTime": 1554530400,
        "temperatureMax": 55.65,
        "temperatureMaxTime": 1554562800,
        "apparentTemperatureMin": 39.53,
        "apparentTemperatureMinTime": 1554530400,
        "apparentTemperatureMax": 55.65,
        "apparentTemperatureMaxTime": 1554562800
      },
      {
        "time": 1554591600,
        "summary": "Mostly cloudy throughout the day.",
        "icon": "partly-cloudy-day",
        "sunriseTime": 1554614672,
        "sunsetTime": 1554662662,
        "moonPhase": 0.07,
        "precipIntensity": 0.0027,
        "precipIntensityMax": 0.0142,
        "precipIntensityMaxTime": 1554649200,
        "precipProbability": 0.51,
        "precipType": "rain",
        "temperatureHigh": 62.26,
        "temperatureHighTime": 1554642000,
        "temperatureLow": 46.74,
        "temperatureLowTime": 1554703200,
        "apparentTemperatureHigh": 62.26,
        "apparentTemperatureHighTime": 1554642000,
        "apparentTemperatureLow": 45.24,
        "apparentTemperatureLowTime": 1554703200,
        "dewPoint": 45.13,
        "humidity": 0.76,
        "pressure": 1007.06,
        "windSpeed": 3.11,
        "windGust": 18.15,
        "windGustTime": 1554591600,
        "windBearing": 43,
        "cloudCover": 0.86,
        "uvIndex": 2,
        "uvIndexTime": 1554631200,
        "visibility": 9.08,
        "ozone": 390.33,
        "temperatureMin": 44.36,
        "temperatureMinTime": 1554613200,
        "temperatureMax": 62.26,
        "temperatureMaxTime": 1554642000,
        "apparentTemperatureMin": 41.39,
        "apparentTemperatureMinTime": 1554613200,
        "apparentTemperatureMax": 62.26,
        "apparentTemperatureMaxTime": 1554642000
      },
      {
        "time": 1554678000,
        "summary": "Overcast throughout the day.",
        "icon": "cloudy",
        "sunriseTime": 1554700938,
        "sunsetTime": 1554749162,
        "moonPhase": 0.1,
        "precipIntensity": 0.0054,
        "precipIntensityMax": 0.0233,
        "precipIntensityMaxTime": 1554724800,
        "precipProbability": 0.94,
        "precipType": "rain",
        "temperatureHigh": 58.27,
        "temperatureHighTime": 1554735600,
        "temperatureLow": 47.51,
        "temperatureLowTime": 1554793200,
        "apparentTemperatureHigh": 58.27,
        "apparentTemperatureHighTime": 1554735600,
        "apparentTemperatureLow": 43.05,
        "apparentTemperatureLowTime": 1554793200,
        "dewPoint": 47.05,
        "humidity": 0.83,
        "pressure": 1010.41,
        "windSpeed": 4.09,
        "windGust": 19.16,
        "windGustTime": 1554760800,
        "windBearing": 60,
        "cloudCover": 0.94,
        "uvIndex": 2,
        "uvIndexTime": 1554717600,
        "visibility": 9.73,
        "ozone": 393.39,
        "temperatureMin": 46.74,
        "temperatureMinTime": 1554703200,
        "temperatureMax": 58.27,
        "temperatureMaxTime": 1554735600,
        "apparentTemperatureMin": 45.24,
        "apparentTemperatureMinTime": 1554703200,
        "apparentTemperatureMax": 58.27,
        "apparentTemperatureMaxTime": 1554735600
      },
      {
        "time": 1554764400,
        "summary": "Foggy in the morning.",
        "icon": "fog",
        "sunriseTime": 1554787205,
        "sunsetTime": 1554835661,
        "moonPhase": 0.13,
        "precipIntensity": 0.0096,
        "precipIntensityMax": 0.0266,
        "precipIntensityMaxTime": 1554789600,
        "precipProbability": 0.91,
        "precipType": "rain",
        "temperatureHigh": 50.98,
        "temperatureHighTime": 1554814800,
        "temperatureLow": 42.41,
        "temperatureLowTime": 1554876000,
        "apparentTemperatureHigh": 50.98,
        "apparentTemperatureHighTime": 1554814800,
        "apparentTemperatureLow": 35.67,
        "apparentTemperatureLowTime": 1554876000,
        "dewPoint": 40.15,
        "humidity": 0.74,
        "pressure": 1012.63,
        "windSpeed": 12.46,
        "windGust": 24.89,
        "windGustTime": 1554822000,
        "windBearing": 63,
        "cloudCover": 0.97,
        "uvIndex": 2,
        "uvIndexTime": 1554804000,
        "visibility": 8.09,
        "ozone": 399.54,
        "temperatureMin": 43.98,
        "temperatureMinTime": 1554847200,
        "temperatureMax": 50.98,
        "temperatureMaxTime": 1554814800,
        "apparentTemperatureMin": 37.22,
        "apparentTemperatureMinTime": 1554847200,
        "apparentTemperatureMax": 50.98,
        "apparentTemperatureMaxTime": 1554814800
      },
      {
        "time": 1554850800,
        "summary": "Mostly cloudy throughout the day.",
        "icon": "partly-cloudy-day",
        "sunriseTime": 1554873472,
        "sunsetTime": 1554922161,
        "moonPhase": 0.17,
        "precipIntensity": 0.0001,
        "precipIntensityMax": 0.0005,
        "precipIntensityMaxTime": 1554930000,
        "precipProbability": 0.05,
        "precipType": "rain",
        "temperatureHigh": 50.95,
        "temperatureHighTime": 1554908400,
        "temperatureLow": 40.14,
        "temperatureLowTime": 1554958800,
        "apparentTemperatureHigh": 50.95,
        "apparentTemperatureHighTime": 1554908400,
        "apparentTemperatureLow": 34.1,
        "apparentTemperatureLowTime": 1554958800,
        "dewPoint": 30.98,
        "humidity": 0.56,
        "pressure": 1018.3,
        "windSpeed": 12.75,
        "windGust": 22.67,
        "windGustTime": 1554850800,
        "windBearing": 53,
        "cloudCover": 0.84,
        "uvIndex": 3,
        "uvIndexTime": 1554897600,
        "visibility": 10,
        "ozone": 407.61,
        "temperatureMin": 42.41,
        "temperatureMinTime": 1554876000,
        "temperatureMax": 50.95,
        "temperatureMaxTime": 1554908400,
        "apparentTemperatureMin": 35.67,
        "apparentTemperatureMinTime": 1554876000,
        "apparentTemperatureMax": 50.95,
        "apparentTemperatureMaxTime": 1554908400
      },
      {
        "time": 1554937200,
        "summary": "Mostly cloudy throughout the day.",
        "icon": "partly-cloudy-day",
        "sunriseTime": 1554959740,
        "sunsetTime": 1555008661,
        "moonPhase": 0.21,
        "precipIntensity": 0.0006,
        "precipIntensityMax": 0.0008,
        "precipIntensityMaxTime": 1555002000,
        "precipProbability": 0.12,
        "precipType": "rain",
        "temperatureHigh": 49.6,
        "temperatureHighTime": 1554987600,
        "temperatureLow": 37.46,
        "temperatureLowTime": 1555045200,
        "apparentTemperatureHigh": 45.34,
        "apparentTemperatureHighTime": 1554987600,
        "apparentTemperatureLow": 32.02,
        "apparentTemperatureLowTime": 1555045200,
        "dewPoint": 31.15,
        "humidity": 0.59,
        "pressure": 1018.29,
        "windSpeed": 9.75,
        "windGust": 17.45,
        "windGustTime": 1554958800,
        "windBearing": 37,
        "cloudCover": 0.86,
        "uvIndex": 3,
        "uvIndexTime": 1554980400,
        "visibility": 10,
        "ozone": 404.63,
        "temperatureMin": 40.14,
        "temperatureMinTime": 1554958800,
        "temperatureMax": 49.6,
        "temperatureMaxTime": 1554987600,
        "apparentTemperatureMin": 34.1,
        "apparentTemperatureMinTime": 1554958800,
        "apparentTemperatureMax": 45.34,
        "apparentTemperatureMaxTime": 1554987600
      }
    ]
  },
  "flags": {
    "sources": [
      "nearest-precip",
      "meteoalarm",
      "cmc",
      "gfs",
      "icon",
      "isd",
      "madis",
      "darksky"
    ],
    "meteoalarm-license": "Based on data from EUMETNET - MeteoAlarm [https://www.meteoalarm.eu/]. Time delays between this website and the MeteoAlarm website are possible; for the most up to date information about alert levels as published by the participating National Meteorological Services please use the MeteoAlarm website.",
    "nearest-station": 3.449,
    "units": "us"
  },
  "offset": 1
}
 * */

use App\WeatherCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WeatherService {
    private $SERVER;
    private $KEY;

    public function __construct() {
        $this->SERVER = 'https://api.darksky.net/';
        $this->KEY = config('darksky.api.key');
    }

    // For testing, abstract the WeatherCache object creation
    protected function getNewWeatherCache(): WeatherCache {
        return new WeatherCache();
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param float $gridsizeKm how big you want the resulting grid size
     * @return array
     */
    protected function roundLatLng(float $latitude, float $longitude, float $gridsizeKm = 6.6): array {
        /// from https://stackoverflow.com/questions/5269703/rounding-lat-and-long-to-show-approximate-location-in-google-maps
        $EARTH_RADIUS_KM = 6371;
        $GRID_SIZE_KM = $gridsizeKm; // <----- Our grid size in km..
        $DEGREES_LAT_GRID = rad2deg($GRID_SIZE_KM / $EARTH_RADIUS_KM);
//     ^^^^^^ This is constant for a given grid size.
        $cos = cos(rad2deg($latitude));

        $degreesLonGrid = $DEGREES_LAT_GRID / $cos;

        return ['latitude' => round(round($latitude / $DEGREES_LAT_GRID) * $DEGREES_LAT_GRID, 6),
            'longitude' => round(round($longitude / $degreesLonGrid) * $degreesLonGrid, 6)];
    }

    protected function populateNewWeatherCacheFromData(float $latitude, float $longitude, \stdClass $weather): WeatherCache {
        $weatherCache = $this->getNewWeatherCache();
        $weatherCache->latitude = $latitude;
        $weatherCache->longitude = $longitude;
        $weatherCache->forecast_updated_date = gmdate('Y-m-d H:i:s');
        $weatherCache->forecast_hour = gmdate('Y-m-d H:00:00', $weather->time);
        $weatherCache->is_current = gmdate('Y-m-d H:00:00') === gmdate('Y-m-d H:00:00', $weather->time);
        if (isset($weather->precipType)) {
            $weatherCache->precip_type = $weather->precipType;
        } else {
            $weatherCache->precip_type = 'none';
        }
        $weatherCache->precip_probability = $weather->precipProbability;
        $weatherCache->precip_intensity = $weather->precipIntensity;
        if (isset($weather->precipIntensityError)) {
            $weatherCache->precip_intensity_error = $weather->precipIntensityError;
        } else {
            $weatherCache->precip_intensity_error = 0.0;
        }
        $weatherCache->precip_probability = $weather->precipProbability;
        if (!$weatherCache->save()) {
            Log::Error('could not save weather ' . json_encode($weather));
        }
        return $weatherCache;
    }

    //Stores generalised form of the weather for later retrieval
    protected function cacheWeather(float $latitude, float $longitude, \stdClass $weather) {
//        $latLng = $this->roundLatLng($latitude, $longitude);
        $this->populateNewWeatherCacheFromData($latitude, $longitude, $weather->currently);

        foreach ($weather->hourly->data as $hourly) {
            $this->populateNewWeatherCacheFromData($latitude, $longitude, $hourly);
        }
    }

    protected function getWeatherFromCache(float $latitude, float $longitude, ?DateTime $specificHour = null): ?WeatherCache {
        $weather = WeatherCache::where('latitude', $latitude)->where('longitude', $longitude);
        //IF the user does not want a specific forecast, we request a 'current' forecast
        if (is_null($specificHour)) {
            $weather = $weather->where('created_at', '>', Carbon::now()->sub('1 hour'))->where('is_current', true);
        } else {
            $weather = $weather->where('created_at', '>', Carbon::now()->sub('1 hour'))->where('forecast_hour', $specificHour->format('Y-m-d H:00:00'));
        }
//        var_dump($weather);
        return $weather->first();

    }

    public function getPrecipitationForecast(float $latitude, float $longitude, array $opts = [], DateTime $specificHour = null) {
        $latLng = $this->roundLatLng((float)$latitude, (float)$longitude);

        $weather = $this->getWeatherFromCache($latLng['latitude'], $latLng['longitude'], $specificHour);

        try {
            if (!$weather instanceof WeatherCache) {
                $weather = $this->getFromApi($latLng['latitude'], $latLng['longitude'], 'forecast', $opts);
                echo "caching weather";
                $this->cacheWeather($latLng['latitude'], $latLng['longitude'], $weather);
                $weather = $this->getWeatherFromCache($latLng['latitude'], $latLng['longitude']);
            }
            return $weather;
        } catch (\Exception $e) {
            Log::Error('could not get weather from api -' . $e->getMessage());
        }
    }


// Create the curl object and set the required options
// - $api will always be https://api.unleashedsoftware.com/
// - $endpoint must be correctly specified
// - $requestUrl does include the "?" if any
// Using the wrong values for $endpoint or $requestUrl will result in a failed API call
    public function getCurl(string $endpoint) {
        return new CurlWrapperService($endpoint);
    }

    protected function makeBaseUrl(string $type, float $lat, float $lng) {
        return rtrim($this->SERVER, '/') . '/' . $type . '/' . $this->KEY . '/' . $lat . ',' . $lng;
    }

    public function formatQueryString(array $opts): string {
        $querystring = '';
        if (is_array($opts)) {
            foreach ($opts as $foreachKey => $value) {
                $querystring .= '&' . $foreachKey . "=" . urlencode($value);
            }
        }
        if (!empty($querystring)) {
            $querystring = '?' . ltrim($querystring, '&');
        }
        return $querystring;

    }

    /**
     * @param float $lat
     * @param float $lng
     * @param string $type
     * @param array $opts
     * @return \stdClass
     * GET something from the API
     * - $request is only any part of the url after the "?"
     * - use $request = "" if there is no request portion
     * - for GET $request will only be the filters eg ?customerName=Bob
     * - $request never includes the "?"
     * Format agnostic method.  Pass in the required $format of FORMAT_JSON or self::FORMAT_XML
     */
    protected function getFromApi(float $lat, float $lng, string $type, array $opts): ?\stdClass {
        $endpoint = $this->makeBaseUrl($type, $lat, $lng);
        $this->lastError = null;
        $querystring = $this->formatQueryString($opts);
        try {
//            echo "REQUEST URI is " . $endpoint . $querystring . "\n";
            // create the curl object
            $curlWrapper = $this->getCurl($endpoint . $querystring);
            // GET something
            $curlResult = $curlWrapper->exec();
//            error_log($curlResult);
            if (0 !== $curlWrapper->getErrNo()) {
                $this->lastError = $curlWrapper->getError();
//                var_dump($curlWrapper->getError());
                throw new \Exception($curlWrapper->getError());
            } else {
                $curlWrapper->close();
                return json_decode($curlResult);
            }
        } catch (\Exception $e) {
            \Log::Error($e->getMessage());
//            error_log($e->getMessage());
            $curlWrapper->close();
            throw $e;
        }
    }


}
