const CleanWebpackPlugin = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const path = require('path');

const prod = process.env.NODE_ENV === 'production';

const plugins = [
  new CleanWebpackPlugin(['public/build']),
  new ManifestPlugin(),
  new MiniCssExtractPlugin({
    filename: '[name].css?id=[chunkhash:5]',
  }),
];

if (!prod) {
  plugins.push(new BrowserSyncPlugin({
    host: 'localhost',
    port: 3000,
    proxy: 'http://localhost:8000/',
    notify: false,
    files: ['./application', './public/build'],
  }));
}

const config = {
  entry: './assets/sources/app.js',
  output: {
    path: path.resolve(__dirname, 'public', 'build'),
    filename: '[name].js?id=[chunkhash:5]',
  },
  plugins,
  mode: prod ? 'production' : 'development',
  // devtool: prod ? false : 'inline-source-map',
  module: {
    rules: [
      {
        test: /\.js$/,
        // exclude: /(node_modules)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['babel-preset-env'],
            plugins: ['babel-plugin-transform-object-rest-spread'],
          },
        },
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader', // translates CSS into CommonJS
          {
            loader: 'sass-loader', // compiles Sass to CSS
            options: { precision: 8 },
          },
        ],
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf|svg|png|jpg|gif)$/,
        use: [
          'file-loader',
        ],
      },
    ],
  },
};

module.exports = config;
