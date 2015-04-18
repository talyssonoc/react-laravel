var Alert = React.createClass({displayName: 'Alert',
  render: function() {
    return React.createElement('div', null, 'Hello, ',
      React.createElement('strong', null, this.props.name)
    );
  }
});